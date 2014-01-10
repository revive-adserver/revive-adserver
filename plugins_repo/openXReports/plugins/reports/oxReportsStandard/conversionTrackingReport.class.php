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

require_once LIB_PATH . '/Extension/reports/ReportsScope.php';

/**
 * A plugin to generate a report showing conversion tracking details, for the
 * supplied date range. The report can contain up to five worksheets:
 *
 *
 * 1. Performance by Day:
 *  - A breakdown of the delivery grouped by day.
 *
 * In the above, "delivery" is the set of all data selected to be displayed
 * by the user's preferences, and can consist of the following items:
 *  - Requests
 *  - Impressions
 *  - Clicks
 *  - CTR: The click through ratio
 *  - Conversions
 *  - Pending Conversions
 *  - Impression SR: The impressions to sales ratio
 *  - Click SR: The clicks to sales ratio
 *  - Revenue
 *  - Cost
 *  - Basket Value: Of conversions
 *  - Number of Items: In conversions
 *  - Revenue CPC: Revenue per click
 *  - ERPM
 *  - ERPC
 *  - ERPS
 *  - EIPM
 *  - EIPC
 *  - EIPS
 *  - EPPM
 *  - EPPC
 *  - EPPS
 *  - ECPM
 *  - ECPC
 *  - ECPS
 *
 *
 * 2. Connection Summary by Day
 *  - A breakdown of the different connection types by day.
 *
 * In the above, "different connection tpyes" are selected from:
 *  - Total Connections
 *  - Pending Connections
 *  - Approved Connections
 *  - Duplicate Connections
 *  - Disapproved Connections
 *  - On Hold Connections
 *  - Ignored Connections
 *
 * Publishers viewing this worksheet may be restricted to the Pending and Approved Connections,
 * if this restriction is set for the publisher.
 *
 *
 * 3. Variable Summary by Day
 *  - A breakdown of the conversions and variables by day.
 *
 * In the above, the "conversions and variables" are:
 *  - The total number of conversions (ie. approved connections)
 *  - If the tracker at least one numeric variable attached:
 *     - The total and average values for each variable value
 *
 *
 * 4. Variable Summary by Variable
 *  - A breakdown of .... ?
 *
 *
 * 5. Connection Detail
 *  - A breakdown of the connection details.
 *
 * In the above, the "connection details" are:
 *  - The connection ID
 *  - The connection date/time
 *  - The connection variable values, if any
 *  - The connection status (eg. Approved, Pending, etc.)
 *  - Any connection comments
 *  - The connection source
 *  - The advertiser name
 *  - The tracker name
 *  - The ad name
 *  - The publisher name
 *  - The zone name
 *  - The connection type
 *  - The ad impression/click time
 *  - The connection IP address
 *  - The connection country
 *  - The connection domain
 *  - The connection language
 *  - The connection operating system
 *  - The connection browser
 *  - The connection window delay
 *
 * @package    OpenXPlugin
 * @subpackage Reports
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Scott Switzer <scott@switzer.org>
 */
class Plugins_Reports_OxReportsStandard_ConversionTrackingReport extends Plugins_ReportsScope
{

    /**
     * The local implementation of the initInfo() method to set all of the
     * required values for this report.
     */
    function initInfo()
    {
        $this->_name         = $this->translate("Conversion Tracking Report");
        $this->_description  = $this->translate("A detailed breakdown of all conversion activity by advertiser or website.");
        $this->_category     = 'standard';
        $this->_categoryName = $this->translate("Standard Reports");
        $this->_author       = 'Scott Switzer';
        $this->_export       = 'xls';
        if ($GLOBALS['_MAX']['CONF']['logging']['trackerImpressions'] && $this->_hasTrackers()) {
            $this->_authorize = array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);
        }

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
    }

    /**
     * The local implementation of the getDefaults() method to prepare the
     * required information for laying out the plugin's report generation
     * screen/the variables required for generating the report.
     */
    function getDefaults()
    {
        // Obtain the user's session-based default values for the report
        global $session;
        $default_period_preset    = isset($session['prefs']['GLOBALS']['report_period_preset'])    ? $session['prefs']['GLOBALS']['report_period_preset']    : 'last_month';
        $default_scope_advertiser = isset($session['prefs']['GLOBALS']['report_scope_advertiser']) ? $session['prefs']['GLOBALS']['report_scope_advertiser'] : '';
        $default_scope_publisher  = isset($session['prefs']['GLOBALS']['report_scope_publisher'])  ? $session['prefs']['GLOBALS']['report_scope_publisher']  : '';
        // Prepare the array for displaying the generation page
        $aImport = array(
            'period' => array(
                'title'            => $GLOBALS['strPeriod'],
                'type'             => 'date-month',
                'default'          => $default_period_preset
            ),
            'scope'  => array(
                'title'            => $GLOBALS['strLimitations'],
                'type'             => 'scope',
                'scope_advertiser' => $default_scope_advertiser,
                'scope_publisher'  => $default_scope_publisher
            ),
            'sheets' => array(
                'title'            => $GLOBALS['strWorksheets'],
                'type'             => 'sheet',
                'sheets'           => array(
                    'performance_by_day'   => $this->translate("Performance by Day"),
                    'connection_by_day'    => $this->translate("Connection Summary by Day"),
                    'variable_by_day'      => $this->translate("Variable Summary by Day"),
                    'variable_by_variable' => $this->translate("Variable Summary by Variable"),
                    'connection_detail'    => $this->translate("Connection Detail")
                )
            )
        );
        return $aImport;
    }

    /**
     * The local implementation of the saveDefaults() method to save the
     * values used for the report by the user to the user's session
     * preferences, so that they can be re-used in other reports.
     */
    function saveDefaults()
    {
        global $session;
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset']    = $_REQUEST['period_preset'];
        }
        if (isset($_REQUEST['scope_advertiser'])) {
            $session['prefs']['GLOBALS']['report_scope_advertiser'] = $_REQUEST['scope_advertiser'];
        }
        if (isset($_REQUEST['scope_publisher'])) {
            $session['prefs']['GLOBALS']['report_scope_publisher']  = $_REQUEST['scope_publisher'];
        }
        phpAds_SessionDataStore();
    }

    /**
     * The local implementation of the execute() method to generate the report.
     *
     * @param OA_Admin_DaySpan $oDaySpan The OA_Admin_DaySpan object for the report.
     * @param Admin_UI_OrganisationScope $oScope The advertiser/publisher scope limitation object.
     * @param array $aSheets  An array of sheets that should be in the report.
     */
    function execute($oDaySpan, $oScope, $aSheets)
    {
        $checkResult = $this->_checkParameters($oDaySpan, $oScope, $aSheets);
        if ($checkResult !== true) {
            return $checkResult;
        }

        // Save the scope for use later
        $this->_oScope = $oScope;
        // Prepare the range information for the report
        $this->_prepareReportRange($oDaySpan);
        // Prepare the report name
        $reportFileName = $this->_getReportFileName();
        // Prepare the output writer for generation
        $this->_oReportWriter->openWithFilename($reportFileName);
        // Prepare the conversion data required for the report
        $aConnections      = $this->_prepareConnections();
        $aTrackerVariables = $this->_prepareTrackerVariables($aConnections);
        $this->_prepareConnectionsWindowDelay($aConnections, $aTrackerVariables);
        // Add the worksheets to the report, as required
        if (isset($aSheets['performance_by_day'])) {
            $this->_addPerformanceByDayWorksheet();
        }
        if (isset($aSheets['connection_by_day'])) {
            $this->_addConnectionByDayWorksheet($aConnections, $aTrackerVariables);
        }
        if (isset($aSheets['variable_by_day'])) {
            $this->_addVariableByDayWorksheet($aConnections, $aTrackerVariables);
        }
        if (isset($aSheets['variable_by_variable'])) {
            $this->_addVariableByVariableWorksheet($aConnections, $aTrackerVariables);
        }
        if (isset($aSheets['connection_detail'])) {
            $this->_addConnectionDetailWorksheet($aConnections, $aTrackerVariables);
        }
        // Close the report writer and send the report to the user
        $this->_oReportWriter->closeAndSend();
    }

    /**
     * Check input parameters
     *
     * @param OA_Admin_DaySpan $oDaySpan The OA_Admin_DaySpan object for the report.
     * @param Admin_UI_OrganisationScope $oScope The advertiser/publisher scope limitation object.
     * @param array $aSheets  An array of sheets that should be in the report.
     *
     * @return bool|int - True if no errors, error code otherwise
     */
    function _checkParameters($oDaySpan, $oScope, $aSheets)
    {
        if (!isset($aSheets['performance_by_day']) &&
            !isset($aSheets['connection_by_day']) &&
            !isset($aSheets['variable_by_day']) &&
            !isset($aSheets['variable_by_variable']) &&
            !isset($aSheets['connection_detail']))
        {
            return PLUGINS_REPORTS_MISSING_SHEETS_ERROR;
        }
        return true;
    }

    /**
     * The local implementation of the _getReportParametersForDisplay() method
     * to return a string to display the date range of the report.
     *
     * @access private
     * @return array The array of index/value sub-headings.
     */
    function _getReportParametersForDisplay()
    {
        $aParams = array();
        $aParams += $this->_getDisplayableParametersFromScope();
        $aParams += $this->_getDisplayableParametersFromDaySpan();
        return $aParams;
    }

    /**
     * A private method to create and add the "performance by day" worksheet
     * of the report.
     *
     * @access private
     */
    function _addPerformanceByDayWorksheet()
    {
        // Prepare the $_REQUEST array as if it was set up via the stats.php page
        if (is_null($this->_oDaySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_oDaySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_oDaySpan->getEndDateString();
        }
        $_REQUEST['breakdown'] = 'day';
        if (!empty($this->_oScope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_oScope->_advertiserId;
        }
        if (!empty($this->_oScope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_oScope->_publisherId;
        }
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
            if (!empty($this->_oScope->_advertiserId) && !empty($this->_oScope->_publisherId)) {
                $controllerType = 'advertiser-affiliate-history';
            } elseif (!empty($this->_oScope->_advertiserId)) {
                $controllerType = 'advertiser-history';
            } elseif (!empty($this->_oScope->_publisherId)) {
                $controllerType = 'affiliate-history';
            } else {
                $controllerType = 'global-history';
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            if (!empty($this->_oScope->_publisherId)) {
                $controllerType = 'advertiser-affiliate-history';
            } else {
                $controllerType = 'advertiser-history';
            }
        } else {
            $controllerType = 'affiliate-history';
        }
        // Get the header and data arrays from the same statistics controllers
        // that prepare stats for the user interface stats pages
        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controllerType);
        // Add the worksheet
        $this->createSubReport(
            $this->translate("Performance by Day"),
            $aHeaders,
            $aData
        );
    }

    /**
     * A private method to create and add the "connection summary by day" worksheet
     * of the report.
     *
     * @access private
     */
    function _addConnectionByDayWorksheet($aConnections, $aTrackerVariables)
    {
        // Create a worksheet
        $worksheetName = $this->translate("Connection Summary by Day");
        $this->_oReportWriter->createReportWorksheet(
            $worksheetName,
            $this->_name,
            $this->_getReportParametersForDisplay(),
            $this->_getReportWarningsForDisplay()
        );
        // Create a subsection for each tracker
        foreach ($aTrackerVariables as $trackerId => $aTracker) {
            $trackerAnonymous = $this->_isTrackerLinkedToAnonymousCampaign($trackerId);
            $trackerName = MAX_getTrackerName($aTracker['tracker_name'], null, $trackerAnonymous, $trackerId);
            $aStatus = $this->_getConnectionStatuses();
            // Prepare the tracker's data
            $aHeaders = array();
            $key = $GLOBALS['strDate'];
            $aHeaders[$key] = 'date';
            $key = $this->translate("Total Connections");
            $aHeaders[$key] = 'number';
            foreach ($aStatus as $status) {
                $key = $status . $this->translate(" Connections");
                $aHeaders[$key] = 'number';
            }
            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                    $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];
                }
            }
            $row = 0;
            if (!empty($aConnections[$trackerId]['connections'])) {
                foreach ($aConnections[$trackerId]['connections'] as $connectionId => $aConnection) {
                    $day = $aConnection['tracker_day'];
                    $status = $aConnection['connection_status'];
                    $aDays[$day]['status'][$status] += 1;
                }
            }
            // Fill in all of the days with data (even if no conversions)
            $oDaySpan = $this->_oDaySpan;
            if (!empty($oDaySpan)) {
                $aDayArray = $oDaySpan->getDayArray();
                foreach ($aDayArray as $day) {
                    if (!isset($aDays[$day])) {
                        $aDays[$day] = array();
                    }
                }
            } else {
                // All statistics selected.  Get the earliest day, and fill in to today
                $curTime = time();
                $minTime = $curTime;
                foreach ($aDays as $day => $aSummary) {
                    $time = strtotime($day);
                    if ($minTime>$time) {
                        $minTime = $time;
                    }
                }
                // Now, fill in the days
                while ($minTime < $curTime) {
                    $day = date('Y-m-d', $minTime);
                    if (!isset($aDays[$day])) {
                        $aDays[$day] = array();
                    }
                    $minTime = mktime(0,0,0,date('m',$minTime),date('d',$minTime)+1,date('Y',$minTime));
                }
            }
            // Sort data
            ksort($aDays);
            $aData = array();
            $row = 0;
            foreach ($aDays as $day => $aDay) {
                $aData[$row][0] = $day;
                $aData[$row][1] = 0; // Total
                $col = 2;
                foreach ($aStatus as $statusId => $status) {
                    $num = $aDay['status'][$statusId] > 0 ? $aDay['status'][$statusId] : 0;
                    $aData[$row][$col++] = $num;
                    $aData[$row][1] += $num;
                }
                $row++;
            }
            // Add the worksheet sub-report
            $this->_oReportWriter->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
            $aDays = array(); // Reset data
        }
    }

    /**
     * A private method to create and add the "variable summary by day" worksheet
     * of the report.
     *
     * @access private
     */
    function _addVariableByDayWorksheet($aConnections, $aTrackerVariables)
    {
        // Create a worksheet
        $worksheetName = $this->translate("Variable Summary by Day");
        $this->_oReportWriter->createReportWorksheet(
            $worksheetName,
            $this->_name,
            $this->_getReportParametersForDisplay(),
            $this->_getReportWarningsForDisplay()
        );
        // Create a subsection for each tracker
        foreach ($aTrackerVariables as $trackerId => $aTracker) {
            $trackerAnonymous = $this->_isTrackerLinkedToAnonymousCampaign($trackerId);
            $trackerName = MAX_getTrackerName($aTracker['tracker_name'], null, $trackerAnonymous, $trackerId);
            // Prepare the tracker's data
            $aHeaders = array();
            $key = $GLOBALS['strDate'];
            $aHeaders[$key] = 'date';
            $key = $GLOBALS['strConversions'];
            $aHeaders[$key] = 'numeric';
            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                    $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];
                    if (($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric') && ($aTrackerVariable['tracker_variable_is_unique'] == 0)) {
                        // Don't display if the user is a publisher and the variable is hidden
                        if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                            $key = $variableName . ' - ' . $GLOBALS['strTotal'];
                            $aHeaders[$key] = 'numeric';
                            $key = $variableName . ' - ' . $GLOBALS['strAverage'];
                            $aHeaders[$key] = 'decimal';
                        }
                    }
                }
            }
            $aDays = array();
            $row = 0;
            if (!empty($aConnections[$trackerId]['connections'])) {
                foreach ($aConnections[$trackerId]['connections'] as $connectionId => $aConnection) {
                    if ($aConnection['connection_status'] != MAX_CONNECTION_STATUS_APPROVED) {
                        continue;
                    }
                    $day = $aConnection['tracker_day'];
                    $aDays[$day]['status'][MAX_CONNECTION_STATUS_APPROVED]++;
                    if (!empty($aConnection['variables'])) {
                        foreach ($aConnection['variables'] as $variableId => $aVariable) {
                            if (($aTracker['variables'][$variableId]['tracker_variable_data_type'] == 'int' || $aTracker['variables'][$variableId]['tracker_variable_data_type'] == 'numeric')
                                && ($aTracker['variables'][$variableId]['tracker_variable_is_unique'] == 0)) {
                                $aDays[$day]['variables'][$variableId] += $aVariable['tracker_variable_value'];
                            }
                        }
                    }
                }
            }
            // Fill in all of the days with data (even if no conversions)
            $oDaySpan = $this->_oDaySpan;
            if (!empty($oDaySpan)) {
                $aDayArray = $oDaySpan->getDayArray();
                foreach ($aDayArray as $day) {
                    if (!isset($aDays[$day])) {
                        $aDays[$day] = array();
                    }
                }
            } else {
                // All statistics selected.  Get the earliest day, and fill in to today
                $curTime = time();
                $minTime = $curTime;
                foreach ($aDays as $day => $aSummary) {
                    $time = strtotime($day);
                    if ($minTime>$time) {
                        $minTime = $time;
                    }
                }
                // Now, fill in the days
                while ($minTime < $curTime) {
                    $day = date('Y-m-d', $minTime);
                    if (!isset($aDays[$day])) {
                        $aDays[$day] = array();
                    }
                    $minTime = mktime(0,0,0,date('m',$minTime),date('d',$minTime)+1,date('Y',$minTime));
                }
            }
            // Sort data
            ksort($aDays);
            $aData = array();
            $row = 0;
            foreach ($aDays as $day => $aDay) {
                $aData[$row][0] = $day;
                $aData[$row][1] = $aDay['status'][MAX_CONNECTION_STATUS_APPROVED];
                $col = 2;
                if (!empty($aTracker['variables'])) {
                    foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                        if ( ($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric')
                          && ($aTrackerVariable['tracker_variable_is_unique'] == 0)
                          && (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || $aTrackerVariable['tracker_variable_hidden'] != 't') ) {
                                $var = $aDay['variables'][$trackerVariableId] > 0 ? $aDay['variables'][$trackerVariableId] : 0;
                                $stat = $aDay['status'][MAX_CONNECTION_STATUS_APPROVED] > 0 ? $aDay['status'][MAX_CONNECTION_STATUS_APPROVED] : 0;
                                $aData[$row][$col++] = $var;
                                $aData[$row][$col++] = ( ($var > 0) && ($stat > 0) ) ? $var / $stat : 0;
                        }
                    }
                }
                $row++;
            }
            $this->_oReportWriter->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
            $aDays = array(); // Reset data
        }
    }

    /**
     * A private method to create and add the "variable summary by variable"
     * worksheet of the report.
     *
     * @access private
     *
     * @TODO Can the logic below be improved? Code seems to only display variables
     *       of date and text type, but there is cut & past code from method above
     *       to format and display totals and averages that is only applicable for
     *       numeric variables..... right????
     */
    function _addVariableByVariableWorksheet($aConnections, $aTrackerVariables)
    {
        // Create a worksheet
        $worksheetName = $this->translate("Variable Summary by Variable");
        $this->_oReportWriter->createReportWorksheet(
            $worksheetName,
            $this->_name,
            $this->_getReportParametersForDisplay(),
            $this->_getReportWarningsForDisplay()
        );
        // Create a subsection for each tracker
        foreach ($aTrackerVariables as $trackerId => $aTracker) {
            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $bdVariableId => $aBdVariable) {
                    // Don't display if:
                    // the user is a publisher and the variable is hidden; or
                    // the tracker variable type is not a string type and not a date type; or
                    // the tracker variable is "unique"
                    if ((OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) && $aBdVariable['tracker_variable_hidden'] == 't') ||
                        ($aBdVariable['tracker_variable_data_type'] != 'string' && $aBdVariable['tracker_variable_data_type'] != 'date') ||
                        $aBdVariable['tracker_variable_is_unique'] == 1) {
                        continue;
                    }
                    $bdVariableName = !empty($aBdVariable['tracker_variable_description']) ? $aBdVariable['tracker_variable_description'] : $aBdVariable['tracker_variable_name'];
                    $trackerAnonymous = $this->_isTrackerLinkedToAnonymousCampaign($trackerId);
                    $trackerName = MAX_getTrackerName($aTracker['tracker_name'].' - '.$bdVariableName, null, $trackerAnonymous, $trackerId);
                    $aHeaders = array();
                    $key = $GLOBALS['strValue'];
                    $aHeaders[$key] = $aBdVariable['tracker_variable_data_type'] == 'date' ? 'datetime' : 'text';
                    $key = $GLOBALS['strConversions'];
                    $aHeaders[$key] = 'numeric';
                    if (!empty($aTracker['variables'])) {
                        foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                            $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];
                            if (($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric') && ($aTrackerVariable['tracker_variable_is_unique'] == 0)) {
                                // Don't display if the user is a publisher and the variable is hidden
                                if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                                    $key = $GLOBALS['strTotal'];
                                    $aHeaders[$key] = 'numeric';
                                    $key = $GLOBALS['strAverage'];
                                    $aHeaders[$key] = 'decimal';
                                }
                            }
                        }
                    }
                    $aVariables = array();
                    $row = 0;
                    if (!empty($aConnections[$trackerId]['connections'])) {
                        foreach ($aConnections[$trackerId]['connections'] as $connectionId => $aConnection) {
                            if ($aConnection['connection_status'] != MAX_CONNECTION_STATUS_APPROVED) {
                                continue;
                            }
                            $aVariables[$aConnection['variables'][$bdVariableId]['tracker_variable_value']]['status'][MAX_CONNECTION_STATUS_APPROVED]++;
                            foreach ($aConnection['variables'] as $variableId => $aVariable) {
                                if (($aTracker['variables'][$variableId]['tracker_variable_data_type'] == 'int' || $aTracker['variables'][$variableId]['tracker_variable_data_type'] == 'numeric')
                                    && ($aTracker['variables'][$variableId]['tracker_variable_is_unique'] == 0)) {
                                    $aVariables[$aConnection['variables'][$bdVariableId]['tracker_variable_value']]['variables'][$variableId] += $aVariable['tracker_variable_value'];
                                }
                            }
                        }
                    }
                    $aData = array();
                    $row = 0;
                    foreach ($aVariables as $value => $aVariable) {
                        $aData[$row][0] = $aBdVariable['tracker_variable_data_type'] == 'date' ? $this->_oReportWriter->convertToDate($value) : $value;
                        $aData[$row][1] = $aVariable['status'][MAX_CONNECTION_STATUS_APPROVED];
                        $col = 2;
                        if (!empty($aTracker['variables'])) {
                            foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                                if ( ($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric')
                                  && ($aTrackerVariable['tracker_variable_is_unique'] == 0)
                                  && (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || $aTrackerVariable['tracker_variable_hidden'] != 't') ) {
                                        $var = $aVariable['variables'][$trackerVariableId] > 0 ? $aVariable['variables'][$trackerVariableId] : 0;
                                        $stat = $aVariable['status'][MAX_CONNECTION_STATUS_APPROVED] > 0 ? $aVariable['status'][MAX_CONNECTION_STATUS_APPROVED] : 0;
                                        $aData[$row][$col++] = $var;
                                        $aData[$row][$col++] = ( ($var > 0) && ($stat > 0) ) ? $var / $stat : 0;
                                }
                            }
                        }
                        $row++;
                    }
                    $this->_oReportWriter->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
                }
            }
        }
    }

    /**
     * A private method to create and add the "connection detail" worksheet
     * of the report.
     *
     * @access private
     */
    function _addConnectionDetailWorksheet($aConnections, $aTrackerVariables)
    {
        // Create a worksheet
        $worksheetName = $this->translate("Connection Detail");
        $this->_oReportWriter->createReportWorksheet(
            $worksheetName,
            $this->_name,
            $this->_getReportParametersForDisplay(),
            $this->_getReportWarningsForDisplay()
        );
        $aStatus = $this->_getConnectionStatuses();
        // Create a subsection for each tracker
        foreach ($aTrackerVariables as $trackerId => $aTracker) {
            $trackerAnonymous = $this->_isTrackerLinkedToAnonymousCampaign($trackerId);
            $trackerName = MAX_getTrackerName($aTracker['tracker_name'], null, $trackerAnonymous, $trackerId);
            $aHeaders = array();
            $key = $this->translate("Connection ID");
            $aHeaders[$key] = 'id';
            $key = $this->translate("Connection Date / Time");
            $aHeaders[$key] = 'datetime';
            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                    $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];
                    // Don't display if the user is a publisher and the variable is hidden
                    if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                        switch ($aTrackerVariable['tracker_variable_data_type']) {
                            case 'int':
                            case 'numeric':
                                $aHeaders[$variableName] = 'numeric';
                                break;
                            case 'date':
                                $aHeaders[$variableName] = 'datetime';
                                break;
                            default:
                                $aHeaders[$variableName] = 'text';
                                break;
                        }
                    }
                }
            }
            $key = $this->translate("Approval Status");
            $aHeaders[$key] = 'text';
            $key = $this->translate("Comment");
            $aHeaders[$key] = 'text';
            if ($this->_shouldDisplaySourceField()) {
                $key = $GLOBALS['strSource'];
                $aHeaders[$key] = 'text';
            }
            $key = $this->translate("Advertiser Name");
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strTrackerName'];
            $aHeaders[$key] = 'text';
            $key = $this->translate("Ad Name");
            $aHeaders[$key] = 'text';
            $key = $this->translate("Website Name");
            $aHeaders[$key] = 'text';
            $key = $this->translate("Zone Name");
            $aHeaders[$key] = 'text';
            $key = $this->translate("Connection Type");
            $aHeaders[$key] = 'text';
            $key = $this->translate("Connecting Value Date / Time");
            $aHeaders[$key] = 'datetime';
            $key = $this->translate("IP Address");
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strCountry'];
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strDomain'];
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strLanguage'];
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strOS'];
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strBrowser'];
            $aHeaders[$key] = 'text';
            $key = $GLOBALS['strWindowDelay'];
            $aHeaders[$key] = 'text';
            $aData = array();
            if (!empty($aConnections[$trackerId]['connections'])) {
                $row = 0;
                foreach ($aConnections[$trackerId]['connections'] as $connectionId => $aConnection) {
                    // Skip connections with a hidden status
                    if (!isset($aStatus[$aConnection['connection_status']])) {
                        continue;
                    }
                    $aData[$row][] = $connectionId;
                    $aData[$row][] = $aConnection['tracker_date_time'];
                    if (!empty($aTracker['variables'])) {
                        foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                            // Don't display if the user is a publisher and the variable is hidden
                            if (!OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                                $value = $aConnection['variables'][$trackerVariableId]['tracker_variable_value'];
                                if ($aTrackerVariable['tracker_variable_data_type'] == 'date') {
                                    // Change value to match Excel format
                                    $value = $this->_oReportWriter->convertToDate($value);
                                }
                                $aData[$row][] = $value;
                            }
                        }
                    }
                    $aData[$row][] = $this->_decodeConnectionStatus($aConnection['connection_status']);
                    $aData[$row][] = $aConnection['connection_comments'];
                    if ($this->_shouldDisplaySourceField()) {
                        $aData[$row][] = $aConnection['connection_channel'];
                    }
                    $aData[$row][] = MAX_getAdvertiserName($aConnection['advertiser_name'], null, $trackerAnonymous, $aConnection['advertiser_id']);
                    $aData[$row][] = $trackerName;
                    $aData[$row][] = MAX_getAdName($aConnection['ad_name'], $aConnection['ad_alt'], null, $trackerAnonymous, $aConnection['ad_id']);
                    $aData[$row][] = MAX_getPublisherName($aConnection['publisher_name'], null, $trackerAnonymous, $aConnection['publisher_id']);
                    $aData[$row][] = MAX_getZoneName($aConnection['zone_name'], null, $trackerAnonymous, $aConnection['zone_id']);
                    $aData[$row][] = $this->_decodeConnectionType($aConnection['connection_action']);
                    $aData[$row][] = $aConnection['connection_date_time'];
                    $aData[$row][] = $aConnection['connection_ip_address'];
                    $aData[$row][] = $aConnection['connection_country'];
                    $aData[$row][] = (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && $trackerAnonymous) ? '' : $aConnection['connection_domain'];
                    $aData[$row][] = $aConnection['connection_language'];
                    $aData[$row][] = $aConnection['connection_os'];
                    $aData[$row][] = $aConnection['connection_browser'];
                    $aData[$row][] = $aConnection['window_delay'];
                    $row++;
                }
            }
            $this->_oReportWriter->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
        }
    }

    /**
     * A private method to test to see if the current user has any trackers.
     *
     * @access private
     * @return boolean True if the current user has trackers, false otherwise.
     */
    function _hasTrackers()
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $aParams = array('advertiser_id' => OA_Permission::getEntityId());
            $aTrackers = Admin_DA::getTrackers($aParams);
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $aParams = array('agency_id' => OA_Permission::getEntityId());
            $aTrackers = Admin_DA::getTrackers($aParams);
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $aTrackers = Admin_DA::getTrackers(array());
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aTrackers = array();
            $aParams = array('publisher_id' => OA_Permission::getEntityId());
            $aPlacementZones = Admin_DA::getPlacementZones($aParams, false, 'placement_id');
            if (!empty($aPlacementZones)) {
                $aParams = array('placement_id' => implode(',', array_keys($aPlacementZones)));
                $aTrackers = array_merge($aTrackers, Admin_DA::getTrackers($aParams));
            }
            $aAdZones = Admin_DA::getAdZones($aParams, false, 'ad_id');
            if (!empty($aAdZones)) {
                $aParams = array('ad_id' => implode(',', array_keys($aAdZones)));
                $aTrackers = array_merge($aTrackers, Admin_DA::getTrackers($aParams));
            }
        }
        return (!empty($aTrackers));
    }

    /**
     * A private method to prepare an array of connections and variable values for the
     * report.
     *
     * @access private
     * @return array An array with the following format:
     *      array(
     *          $trackerId => array(
     *              'connections' => array(
     *                  $connectionId => array(
     *                      'data_intermediate_ad_connection_id' => Integer:   The conversion ID
     *                      'tracker_date_time'                  => Timestamp: The date/time of the conversion
     *                      'tracker_day'                        => String:    The day of the conversion in YYYY-MM-DD format
     *                      'connection_date_time'               => Timestamp: The date/time of the ad impression/click
     *                      'connection_status'                  => Integer:   The status of the connection
     *                      'connection_channel'                 => Integer:   The channel ID of the ad impression/click
     *                      'connection_action'                  => Integer:   If it was an ad impression or click
     *                      'connection_ip_address'              => String:    The IP address of the ad impression/click
     *                      'connection_country'                 => String:    The country of the ad impression/click
     *                      'connection_domain'                  => String:    The domain of the ad impression/click
     *                      'connection_language'                => String:    The language of the ad impression/click
     *                      'connection_os'                      => String:    The operating system of the ad impression/click
     *                      'connection_browser'                 => String:    The browser of the ad impression/click
     *                      'connection_comments'                => String:    Any comments associated with the connection
     *                      'advertiser_id'                      => Integer:   The advertiser ID of the ad impression/click
     *                      'advertiser_name'                    => String:    The name of the advertiser of the ad impression/click
     *                      'placement_id'                       => Integer:   The placement ID of the ad impression/click
     *                      'placement_name'                     => String:    The name of the placement of the ad impression/click
     *                      'ad_id'                              => Integer:   The ad ID of the ad impression/click
     *                      'ad_name'                            => String:    The name of the ad of the ad impression/click
     *                      'ad_alt'                             => String:    The alt. name of the ad of the ad impression/click
     *                      'publisher_id'                       => Integer:   The publisher ID of the ad impression/click
     *                      'publisher_name'                     => String:    The name of the publisher of the ad impression/click
     *                      'zone_id'                            => Integer:   The zone ID of the ad impression/click
     *                      'zone_name'                          => String:    The name of the zone of the ad impression/click
     *                      'tracker_id'                         => Integer:   The tracker ID for the conversion
     *                      'variables'                          => array(
     *                          $trackerVariableId => array(
     *                              tracker_variable_id    => Integer: The tracker variable ID
     *                              tracker_variable_value => Mixed:   The tracker variable value for the conversion
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      )
     */
    function _prepareConnections()
    {
        $aConnections = array();
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Prepare the start and end dates for the conversion range
        $oDaySpan = new OA_Admin_DaySpan();
        $oDaySpan->setSpanDays($this->_oDaySpan->oStartDate, $this->_oDaySpan->oEndDate);
        $oDaySpan->toUTC();
        $startDateString = $oDaySpan->getStartDateString('%Y-%m-%d %H:%M:%S');
        $endDateString   = $oDaySpan->getEndDateString('%Y-%m-%d %H:%M:%S');
        // Prepare the agency/advertiser/publisher limitations
        $agencyId     = $this->_oScope->getAgencyId();
        $advertiserId = $this->_oScope->getAdvertiserId();
        $publisherId  = $this->_oScope->getPublisherId();
        // Prepare the query to select the required conversions and variable values
        $query = "
            SELECT
                diac.data_intermediate_ad_connection_id AS data_intermediate_ad_connection_id,
                diac.tracker_date_time AS tracker_date_time,
                diac.tracker_id AS tracker_id,
                diac.connection_date_time AS connection_date_time,
                diac.connection_status AS connection_status,
                diac.connection_channel AS connection_channel,
                diac.connection_action AS connection_action,
                diac.tracker_ip_address AS connection_ip_address,
                diac.tracker_country AS connection_country,
                diac.tracker_domain AS connection_domain,
                diac.tracker_language AS connection_language,
                diac.tracker_os AS connection_os,
                diac.tracker_browser AS connection_browser,
                diac.comments AS connection_comments,
                z.zoneid AS zone_id,
                z.zonename AS zone_name,
                p.affiliateid AS publisher_id,
                p.name AS publisher_name,
                a.clientid AS advertiser_id,
                a.clientname AS advertiser_name,
                c.campaignid AS placement_id,
                c.campaignname AS campaign_name,
                b.bannerid AS ad_id,
                b.description AS ad_name,
                b.alt AS ad_alt,
                diavv.tracker_variable_id AS tracker_variable_id,
                diavv.value AS tracker_variable_value
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_connection']} AS diac
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['banners']} AS b
            ON
                (
                    diac.ad_id = b.bannerid
                )
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['campaigns']} AS c
            ON
                (
                    b.campaignid = c.campaignid
                )
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['clients']} AS a
            ON
                (
                    c.clientid = a.clientid
                )
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['zones']} AS z
            ON
                (
                    diac.zone_id = z.zoneid
                )
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['affiliates']} AS p
            ON
                (
                    z.affiliateid = p.affiliateid
                )
            LEFT JOIN
                {$aConf['table']['prefix']}{$aConf['table']['data_intermediate_ad_variable_value']} AS diavv
            ON
                (
                    diac.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id
                )
            WHERE
                diac.tracker_date_time >= " . DBC::makeLiteral($startDateString, 'string') . "
                AND
                diac.tracker_date_time <= " . DBC::makeLiteral($endDateString, 'string') . "
                AND
                diac.inside_window = 1";
        if ($agencyId) {
            $query .= "
                AND
                a.agencyid = " . DBC::makeLiteral($agencyId, 'integer');
        }
        if ($advertiserId) {
            $query .= "
                AND
                a.clientid = " . DBC::makeLiteral($advertiserId, 'integer');
        }
        if ($publisherId) {
            $query .= "
                AND
                z.affiliateid = " . DBC::makeLiteral($publisherId, 'integer');
        }
        $query .= "
            ORDER BY
                tracker_id,
                data_intermediate_ad_connection_id";
        // Select the conversions in the report
        $rsConversions = DBC::NewRecordSet($query);
        $rsConversions->find();
        while ($rsConversions->fetch()) {
            $aConversion = $rsConversions->toArray();
            $trackerId    = $aConversion['tracker_id'];
            $connectionId = $aConversion['data_intermediate_ad_connection_id'];
            // Does this tracker/connection pair exist in the result array already?
            // It might, due to multiple attached variable values...
            if (!isset($aConnections[$trackerId]['connections'][$connectionId])) {
                // It's not set, store the connection details
                $oTrackerDate = new Date($aConversion['tracker_date_time']);
                $oTrackerDate->setTZbyID('UTC');
                $oTrackerDate->convertTZ($this->_oDaySpan->oStartDate->tz);
                $oConnectionDate = new Date($aConversion['connection_date_time']);
                $oConnectionDate->setTZbyID('UTC');
                $oConnectionDate->convertTZ($this->_oDaySpan->oStartDate->tz);
                $aConnections[$trackerId]['connections'][$connectionId] = array (
                    'data_intermediate_ad_connection_id' => $connectionId,
                    'tracker_date_time'                  => $oTrackerDate->format('%Y-%m-%d %H:%M:%S'),
                    'tracker_day'                        => $oTrackerDate->format('%Y-%m-%d'),
                    'connection_date_time'               => $oConnectionDate->format('%Y-%m-%d %H:%M:%S'),
                    'connection_status'                  => $aConversion['connection_status'],
                    'connection_channel'                 => $aConversion['connection_channel'],
                    'connection_action'                  => $aConversion['connection_action'],
                    'connection_ip_address'              => $aConversion['connection_ip_address'],
                    'connection_country'                 => $aConversion['connection_country'],
                    'connection_domain'                  => $aConversion['connection_domain'],
                    'connection_language'                => $aConversion['connection_language'],
                    'connection_os'                      => $aConversion['connection_os'],
                    'connection_browser'                 => $aConversion['connection_browser'],
                    'connection_comments'                => $aConversion['connection_comments'],
                    'advertiser_id'                      => $aConversion['advertiser_id'],
                    'advertiser_name'                    => $aConversion['advertiser_name'],
                    'placement_id'                       => $aConversion['placement_id'],
                    'placement_name'                     => $aConversion['placement_name'],
                    'ad_id'                              => $aConversion['ad_id'],
                    'ad_name'                            => $aConversion['ad_name'],
                    'ad_alt'                             => $aConversion['ad_alt'],
                    'publisher_id'                       => $aConversion['publisher_id'],
                    'publisher_name'                     => $aConversion['publisher_name'],
                    'zone_id'                            => $aConversion['zone_id'],
                    'zone_name'                          => $aConversion['zone_name'],
                    'tracker_id'                         => $aConversion['tracker_id'],
                );
            }
            // Store the variable value associated with this connection, if one exists
            $trackerVariableId = $aConversion['tracker_variable_id'];
            if (!empty($trackerVariableId)) {
                $aConnections[$trackerId]['connections'][$connectionId]['variables'][$trackerVariableId] = array (
                    'tracker_variable_id'    => $trackerVariableId,
                    'tracker_variable_value' => $aConversion['tracker_variable_value'],
                );
            }
        }
        // Return the connections
        return $aConnections;
    }

    /**
     * A private method to obtain the tracker variable details for conversions
     * found in the {@link Plugins_Reports_Standard_ConversionTrackingReport::_prepareConnections()}
     * method
     *
     * @access private
     * @param array $aConnections An array, indexed by tracker ID, of conversion data. The
     *                            index keys (ie. the tracker IDs) are all that are relevant
     *                            to this method.
     * @return array An array with the following format:
     *      array(
     *          $trackerId => array(
     *              'tracker_id'   => Integer: The tracker ID
     *              'tracker_name' => String:  The tracker name
     *              'variables'    => array(
     *                  $trackerVariableId => array(
     *                      tracker_variable_id          => Integer: The variable ID
     *                      tracker_variable_name        => String:  The variable name
     *                      tracker_variable_description => String:  The variable description
     *                      tracker_variable_data_type   =>
     *                      tracker_variable_purpose     =>
     *                      tracker_variable_is_unique   =>
     *                      tracker_variable_hidden      => String:  Either 't' or 'f'
     *              )
     *          )
     *      )
     *
     */
    function _prepareTrackerVariables($aConnections)
    {
        $aTrackerVariables = array();
        $aConf = $GLOBALS['_MAX']['CONF'];
        // If the user is a publisher, set the publisher ID
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $publisherId = OA_Permission::getEntityId();
        } else {
            $publisherId = 0;
        }
        // Prepare the query to select the required tracker variable values
        $trackerIds = implode(',', array_keys($aConnections));
        // Query Data Base only if there are connections
        if (!empty($trackerIds)) {
            $query = "
                SELECT
                    t.trackerid AS tracker_id,
                    t.trackername AS tracker_name,
                    v.variableid AS tracker_variable_id,
                    v.name AS tracker_variable_name,
                    v.description AS tracker_variable_description,
                    v.datatype AS tracker_variable_data_type,
                    v.purpose AS tracker_variable_purpose,
                    v.is_unique AS tracker_variable_is_unique,
                    v.hidden AS tracker_variable_hidden,
                    vp.visible AS tracker_variable_visible
                FROM
                    {$aConf['table']['prefix']}{$aConf['table']['trackers']} AS t
                LEFT JOIN
                    {$aConf['table']['prefix']}{$aConf['table']['variables']} AS v
                ON
                    (
                        t.trackerid = v.trackerid
                    )
                LEFT JOIN
                    {$aConf['table']['prefix']}{$aConf['table']['variable_publisher']} AS vp
                ON
                    (
                        v.variableid = vp.variable_id
                        AND
                        vp.publisher_id = $publisherId
                    )
                WHERE
                    t.trackerid IN ( " . $trackerIds . ")
                ORDER BY
                    tracker_id";
            // Select the tracker variables needed for the report
            $rsTrackerVariables = DBC::NewRecordSet($query);
            $rsTrackerVariables->find();
            while ($rsTrackerVariables->fetch()) {
                $aTrackerVariable = $rsTrackerVariables->toArray();
                $trackerId = $aTrackerVariable['tracker_id'];
                // Is the tracker already set in the array?
                // It might be, in the case of a tracker having multiple variables...
                if (!isset($aTrackerVariables[$trackerId])) {
                    // It's not set, store the tracker ID and name
                    $aTrackerVariables[$trackerId]['tracker_id']   = $trackerId;
                    $aTrackerVariables[$trackerId]['tracker_name'] = $aTrackerVariable['tracker_name'];
                }
                // Store the variable associated with this tracker, if one exists
                $trackerVariableId = $aTrackerVariable['tracker_variable_id'];
                if (!empty($trackerVariableId)) {
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_id']          = $trackerVariableId;
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_name']        = $aTrackerVariable['tracker_variable_name'];
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_description'] = $aTrackerVariable['tracker_variable_description'];
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_data_type']   = $aTrackerVariable['tracker_variable_data_type'];
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_purpose']     = $aTrackerVariable['tracker_variable_purpose'];
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_is_unique']   = $aTrackerVariable['tracker_variable_is_unique'];
                    $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_hidden']      = $aTrackerVariable['tracker_variable_hidden'];
                    if (!is_null($aTrackerVariable['tracker_variable_visible'])) {
                        $aTrackerVariables[$trackerId]['variables'][$trackerVariableId]['tracker_variable_hidden']  = $aTrackerVariable['tracker_variable_visible'] ? 'f' : 't';
                    }
                }
            }
        }
        return $aTrackerVariables;
    }

    /**
     * A private method to prepare the conversion window delay values. On return, changes the
     * $aConnections parameter to have the required
     * $aConnections[$trackerId]['connections'][$conversionId]['window_delay'] values set.
     *
     * @access private
     * @param array $aConnections An array in the format of the result of the
     *                            {@link Plugins_Reports_Standard_ConversionTrackingReport::_prepareConnections()}
     * @param array $aTrackerVariables An array in the format of the result of the
     *                                 {@link Plugins_Reports_Standard_ConversionTrackingReport::_prepareTrackerVariables()}
     *                                 method.
     */
    function _prepareConnectionsWindowDelay(&$aConnections, $aTrackerVariables)
    {
        foreach ($aConnections as $trackerId => $aTracker) {
            foreach($aTracker['connections'] as $connectionId => $aConnection) {
                // Count the window delay
   	            $eventDateSt = strtotime($aConnection['tracker_date_time']." ");
                $secondsLeft = $eventDateSt - strtotime($aConnection['connection_date_time']." ");
                $days        = intval($secondsLeft / 86400);  // 86400 seconds in a day
                $partDay     = $secondsLeft - ($days * 86400);
                $hours       = intval($partDay / 3600);  // 3600 seconds in an hour
                $partHour    = $partDay - ($hours * 3600);
                $minutes     = intval($partHour / 60);  // 60 seconds in a minute
                $seconds     = $partHour - ($minutes * 60);
                $windowDelay = $days."d ".$hours."h ".$minutes."m ".$seconds."s";
                $aConnections[$trackerId]['connections'][$connectionId]['window_delay'] = $windowDelay;
            }
        }
    }


    /**
     * A private method to determine if a tracker is linked to an anonymous
     * campaign or not.
     *
     * @access private
     * @param integer $trackerId The tracker ID.
     * @return boolean True if the tracker is linked to an anonymous campaign,
     *                 false otherwise.
     */
    function _isTrackerLinkedToAnonymousCampaign($trackerId)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $query = "
            SELECT
                c.anonymous
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['trackers']} AS t
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['campaigns_trackers']} AS ct
            ON
                (
                    t.trackerid = ct.trackerid
                )
            JOIN
                {$aConf['table']['prefix']}{$aConf['table']['campaigns']} AS c
            ON
                (
                    c.campaignid = ct.campaignid
                )
            WHERE
                t.trackerid = ". DBC::makeLiteral($trackerId, 'integer');
        $rsTracker = DBC::NewRecordSet($query);
        $rsTracker->find();
        if (!$rsTracker->fetch()) {
            // Unknown if anonymous or not! Return true to prevent
            // accidental information leakage...
            return true;
        }
        $aTracker = $rsTracker->toArray();
        if ($aTracker['anonymous'] == 't') {
            return true;
        }
        return false;
    }

    /**
     * A private method to determine if a source field should be displayed,
     * based on the current user.
     *
     * @access private
     * @return boolean Falseif the user is an advertiser, true otherwise.
     */
    function _shouldDisplaySourceField()
    {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            return false;
        }
        return true;
    }

    /**
     * A private method to "decode" a connection type to a string.
     *
     * @access private
     * @param integer $code The connection type code.
     * @return string The translated text value, eg. "Integer".
     */
    function _decodeConnectionType($code)
    {
        switch ($code)
        {
            case MAX_CONNECTION_AD_IMPRESSION:
                return $GLOBALS['strImpression'];
            case MAX_CONNECTION_AD_CLICK:
                return $GLOBALS['strClick'];
            case MAX_CONNECTION_AD_MANUAL:
                return $GLOBALS['strManual'];
            case MAX_CONNECTION_AD_ARRIVAL:
                return $GLOBALS['strArrival'];
        }
        return $GLOBALS['strUnknown'];
    }

    /**
     * A private method to return the connection statuses the user can view,
     * indexed by number, and with the appropriate NON-TRANSLATED name for
     * display. (Values will be used as part of translation name later.)
     *
     * @return array The array of statuses.
     */
    function _getConnectionStatuses()
    {
        return array(
            MAX_CONNECTION_STATUS_PENDING     => $GLOBALS['strStatusPending'],
            MAX_CONNECTION_STATUS_APPROVED    => $GLOBALS['strStatusApproved'],
            MAX_CONNECTION_STATUS_DUPLICATE   => $GLOBALS['strStatusDuplicate'],
            MAX_CONNECTION_STATUS_DISAPPROVED => $GLOBALS['strStatusDisapproved'],
            MAX_CONNECTION_STATUS_ONHOLD      => $GLOBALS['strStatusOnHold'],
            MAX_CONNECTION_STATUS_IGNORE      => $GLOBALS['strStatusIgnore'],
        );
    }

    /**
     * A private method to return the translated connection status of a connection.
     *
     * @access private
     * @param integer $code A connection status type code.
     * @return string The translated text value, eg. "Approved".
     */
    function _decodeConnectionStatus($code)
    {
        $aStatus = $this->_getConnectionStatuses();
        return $this->translate($aStatus[$code]);
    }

}

?>
