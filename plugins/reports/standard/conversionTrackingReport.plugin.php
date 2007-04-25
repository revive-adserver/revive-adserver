<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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

require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/Admin/Reporting/ReportScope.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/plugins/reports/proprietary/TrackerVariable.php';

class Plugins_Reports_Standard_ConversionTrackingReport extends EnhancedReport
{
    /* @var ReportScope */
    var $_scope;

    /* @var DaySpan */
    var $_daySpan;

    function initInfo()
    {
        $this->_name = MAX_Plugin_Translation::translate('Conversion Tracking Report', $this->module, $this->package);
        $this->_category = 'standard';
        $this->_categoryName = MAX_Plugin_Translation::translate('Standard Reports', $this->module, $this->package);
        $this->_description = MAX_Plugin_Translation::translate('A detailed breakdown of all conversion activity by advertiser or publisher.', $this->module, $this->package);

        if ($this->_hasTrackers()) {
            $this->_authorize = phpAds_Publisher | phpAds_Advertiser | phpAds_Agency | phpAds_Admin;
        }

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
    }
    /**
     * Check to see if any trackers are associated with traffic...
     *
     */
    function _hasTrackers()
    {
        if (phpAds_isUser(phpAds_Advertiser)) {
            $aParams = array('advertiser_id' => phpAds_getUserID());
            $aTrackers = Admin_DA::getTrackers($aParams);
        } elseif (phpAds_isUser(phpAds_Agency)) {
            $aParams = array('agency_id' => phpAds_getUserID());
            $aTrackers = Admin_DA::getTrackers($aParams);
        } elseif (phpAds_isUser(phpAds_Admin)) {
            $aTrackers = Admin_DA::getTrackers(array());
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            $aTrackers = array();
            $aParams = array('publisher_id' => phpAds_getUserID());
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

    function getDefaults()
    {
        global $session;

        $aImport = array();

        $default_scope_advertiser = isset($session['prefs']['GLOBALS']['report_scope_advertiser']) ? $session['prefs']['GLOBALS']['report_scope_advertiser'] : '';
        $default_scope_publisher = isset($session['prefs']['GLOBALS']['report_scope_publisher']) ? $session['prefs']['GLOBALS']['report_scope_publisher'] : '';
        $aImport['scope'] = array(
            'title' => MAX_Plugin_Translation::translate('Limitations', $this->module, $this->package),
            'type' => 'scope',
            'filter' => 'tracker-present',
            'scope_advertiser' => $default_scope_advertiser,
            'scope_publisher' => $default_scope_publisher
        );

        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        $aImport['period'] = array(
            'title' => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
            'type' => 'date-month',
            'default' => $default_period_preset
        );

        $aImport['sheets'] = array(
            'title'  => MAX_Plugin_Translation::translate('Worksheets', $this->module, $this->package),
            'type'   => 'sheet',
            'sheets' => array(
                'performance_by_day'   => MAX_Plugin_Translation::translate('Performance by Day', $this->module, $this->package),
                'connection_by_day'    => MAX_Plugin_Translation::translate('Connection Summary by Day', $this->module, $this->package),
                'variable_by_day'      => MAX_Plugin_Translation::translate('Variable Summary by Day', $this->module, $this->package),
                'variable_by_variable' => MAX_Plugin_Translation::translate('Variable Summary by Variable', $this->module, $this->package),
                'conversion_detail'    => MAX_Plugin_Translation::translate('Conversion Detail', $this->module, $this->package)
            )
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['scope_advertiser'])) {
            $session['prefs']['GLOBALS']['report_scope_advertiser'] = $_REQUEST['scope_advertiser'];
        }
        if (isset($_REQUEST['scope_publisher'])) {
            $session['prefs']['GLOBALS']['report_scope_publisher'] = $_REQUEST['scope_publisher'];
        }
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset'] = $_REQUEST['period_preset'];
        }
        phpAds_SessionDataStore();
    }

    function execute($scope, $oDaySpan, $sheets)
    {
        $this->_scope = $scope;
        $this->_daySpan = $oDaySpan;
        $startDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getStartDateString())): 'Beginning';
        $endDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getEndDateString())): date('Y-M-d');
        $reportName = $this->_name . ' from ' . $startDate . ' to ' . $endDate . '.xls';
        $this->_report_writer->openWithFilename($reportName);
        $aConnections = $this->dal->getTrackerConnections($scope, $oDaySpan);
        $aTrackers = $this->dal->getTrackersVariablesByTrackerId($aConnections);

        // reformat Ticketmaster 'Date of Event' fields
        // a) find relevant tracker variable ids
        // b) reformat the values of these variables wherever they occur in the connections data
        foreach ($aTrackers as $tracker) {

            foreach ($tracker['variables'] as $variable) {
                if ($variable['tracker_variable_name'] == 'dateofevent') {
                    $ids_to_format[] = $variable['tracker_variable_id'];
                }
            }
        }
        foreach($aConnections as $tracker_id => $tracker) {
            foreach($tracker['connections'] as $connection_id => $connection) {
                foreach($ids_to_format as $id) {
                    if (isset($aConnections[$tracker_id]['connections'][$connection_id]['variables'][$id]['tracker_variable_value'])) {
                        $date_of_event = $aConnections[$tracker_id]['connections'][$connection_id]['variables'][$id]['tracker_variable_value'];
                        $doe_timestamp = strtotime(str_replace(',', '', $date_of_event));
                        $new_datestring = strftime('%Y-%m-%d %H:%M:%S', $doe_timestamp);
                        $aConnections[$tracker_id]['connections'][$connection_id]['variables'][$id]['tracker_variable_value'] = $new_datestring;
                    }
                }
                //count window delay
   	        $eventDateSt = strtotime($connection['tracker_date_time']." ");
                $secondsLeft = $eventDateSt - strtotime($connection['connection_date_time']." ");
                $days = intval($secondsLeft / 86400);  // 86400 seconds in a day
                $partDay = $secondsLeft - ($days * 86400);
                $hours = intval($partDay / 3600);  // 3600 seconds in an hour
                $partHour = $partDay - ($hours * 3600);
                $minutes = intval($partHour / 60);  // 60 seconds in a minute
                $seconds = $partHour - ($minutes * 60);
                $windowDelay = $days."d ".$hours."h ".$minutes."m ".$seconds."s";
	        $aConnections[$tracker_id]['connections'][$connection_id]['window_delay'] = $windowDelay;

            }
        }

        if (isset($sheets['performance_by_day']) || !count($sheets)) {
            $this->addPerformanceSheet();
        }
        if (isset($sheets['connection_by_day'])) {
            $this->addConversionSummaryByDaySheet($aTrackers, $aConnections);
        }
        if (isset($sheets['variable_by_day'])) {
            $this->addVariableSummaryByDaySheet($aTrackers, $aConnections);
        }
        if (isset($sheets['variable_by_variable'])) {
            $this->addVariableSummaryByVariableSheet($aTrackers, $aConnections);
        }
        if (isset($sheets['conversion_detail'])) {
            $this->addConversionDetailSheet($aTrackers, $aConnections);
        }
        $this->_report_writer->closeAndSend();
    }

    function addConversionSummaryByDaySheet($aTrackers, $aConnections)
    {
        $worksheetName = MAX_Plugin_Translation::translate('Connection Summary by Day', $this->module, $this->package);
        $this->_report_writer->createReportWorksheet($worksheetName, $this->_name, $this->getReportParametersForDisplay());

        // Create a subsection for each tracker
        foreach ($aTrackers as $trackerId => $aTracker) {

            $trackerAnonymous = $this->dal->isTrackerLinkedToAnonymousCampaign($trackerId);
            $trackerName = MAX_getTrackerName($aTracker['tracker_name'], null, $trackerAnonymous, $trackerId);
            $aStatus = $this->getConnectionStatuses();

            $aHeaders = array();
            $aHeaders['Date'] = 'date';
            $aHeaders['Total Connections'] = 'number';
            foreach ($aStatus as $status) {
                $aHeaders[$status . ' Connections'] = 'number';
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
            $oDaySpan = $this->_daySpan;
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
            $this->_report_writer->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
            $aDays = array(); // reset data
        }
    }

    function addVariableSummaryByDaySheet($aTrackers, $aConnections)
    {
        $worksheetName = MAX_Plugin_Translation::translate('Variable Summary by Day', $this->module, $this->package);
        $this->_report_writer->createReportWorksheet($worksheetName, $this->_name, $this->getReportParametersForDisplay());

        // Create a subsection for each tracker
        foreach ($aTrackers as $trackerId => $aTracker) {

            $trackerAnonymous = $this->dal->isTrackerLinkedToAnonymousCampaign($trackerId);
            $trackerName = MAX_getTrackerName($aTracker['tracker_name'], null, $trackerAnonymous, $trackerId);
            $aStatus = $this->getConnectionStatuses();

            $aHeaders = array();
            $aHeaders['Date'] = 'date';
            $aHeaders['Conversions'] = 'numeric';
            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                    $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];

                    if (($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric') && ($aTrackerVariable['tracker_variable_is_unique'] == 0)) {
                        // Don't display if the user is a publisher and the variable is hidden
                        if (!phpAds_isUser(phpAds_Publisher) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                            $aHeaders['Total ' . $variableName] = 'numeric';
                            $aHeaders['Average ' . $variableName] = 'decimal';
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
            $oDaySpan = $this->_daySpan;
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
                          && (!phpAds_isUser(phpAds_Publisher) || $aTrackerVariable['tracker_variable_hidden'] != 't') ) {
                                $var = $aDay['variables'][$trackerVariableId] > 0 ? $aDay['variables'][$trackerVariableId] : 0;
                                $stat = $aDay['status'][MAX_CONNECTION_STATUS_APPROVED] > 0 ? $aDay['status'][MAX_CONNECTION_STATUS_APPROVED] : 0;
                                $aData[$row][$col++] = $var;
                                $aData[$row][$col++] = ( ($var > 0) && ($stat > 0) ) ? $var / $stat : 0;
                        }
                    }
                }
                $row++;
            }
            $this->_report_writer->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
            $aDays = array(); // reset data
        }
    }

    function addVariableSummaryByVariableSheet($aTrackers, $aConnections)
    {
        $worksheetName = MAX_Plugin_Translation::translate('Variable Summary by Variable', $this->module, $this->package);
        $this->_report_writer->createReportWorksheet($worksheetName, $this->_name, $this->getReportParametersForDisplay());

        // Create a subsection for each tracker
        foreach ($aTrackers as $trackerId => $aTracker) {
            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $bdVariableId => $aBdVariable) {
                    // Don't display if the user is a publisher and the variable is hidden
                    if ((phpAds_isUser(phpAds_Publisher) && $aBdVariable['tracker_variable_hidden'] == 't') ||
                        ($aBdVariable['tracker_variable_data_type'] != 'string' && $aBdVariable['tracker_variable_data_type'] != 'date') ||
                        $aBdVariable['tracker_variable_is_unique'] == 1) {
                        continue;
                    }
                    $bdVariableName = !empty($aBdVariable['tracker_variable_description']) ? $aBdVariable['tracker_variable_description'] : $aBdVariable['tracker_variable_name'];
                    $trackerAnonymous = $this->dal->isTrackerLinkedToAnonymousCampaign($trackerId);
                    $trackerName = MAX_getTrackerName($aTracker['tracker_name'].' - '.$bdVariableName, null, $trackerAnonymous, $trackerId);

                    $aHeaders = array();
                    $aHeaders['Value'] = $aBdVariable['tracker_variable_data_type'] == 'date' ? 'datetime' : 'text';
                    $aHeaders['Conversions'] = 'numeric';
                    if (!empty($aTracker['variables'])) {
                        foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                            $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];
                            if (($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric') && ($aTrackerVariable['tracker_variable_is_unique'] == 0)) {
                                // Don't display if the user is a publisher and the variable is hidden
                                if (!phpAds_isUser(phpAds_Publisher) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                                    $aHeaders['Total ' . $variableName] = 'numeric';
                                    $aHeaders['Average ' . $variableName] = 'decimal';
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
                        $aData[$row][0] = $aBdVariable['tracker_variable_data_type'] == 'date' ? $this->_report_writer->convertToDate($value) : $value;
                        $aData[$row][1] = $aVariable['status'][MAX_CONNECTION_STATUS_APPROVED];
                        $col = 2;
                        if (!empty($aTracker['variables'])) {
                            foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                                if ( ($aTrackerVariable['tracker_variable_data_type'] == 'int' || $aTrackerVariable['tracker_variable_data_type'] == 'numeric')
                                  && ($aTrackerVariable['tracker_variable_is_unique'] == 0)
                                  && (!phpAds_isUser(phpAds_Publisher) || $aTrackerVariable['tracker_variable_hidden'] != 't') ) {
                                        $var = $aVariable['variables'][$trackerVariableId] > 0 ? $aVariable['variables'][$trackerVariableId] : 0;
                                        $stat = $aVariable['status'][MAX_CONNECTION_STATUS_APPROVED] > 0 ? $aVariable['status'][MAX_CONNECTION_STATUS_APPROVED] : 0;
                                        $aData[$row][$col++] = $var;
                                        $aData[$row][$col++] = ( ($var > 0) && ($stat > 0) ) ? $var / $stat : 0;
                                }
                            }
                        }
                        $row++;
                    }

                    $this->_report_writer->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
                }
            }
        }
    }

    function addConversionDetailSheet($aTrackers, $aConnections)
    {
        $worksheetName = MAX_Plugin_Translation::translate('Conversion Detail', $this->module, $this->package);
        $this->_report_writer->createReportWorksheet($worksheetName, $this->_name, $this->getReportParametersForDisplay());

        $aStatus = $this->getConnectionStatuses();

        // Create a subsection for each tracker
        foreach ($aTrackers as $trackerId => $aTracker) {

            $trackerAnonymous = $this->dal->isTrackerLinkedToAnonymousCampaign($trackerId);
            $trackerName = MAX_getTrackerName($aTracker['tracker_name'], null, $trackerAnonymous, $trackerId);

            $aHeaders = array();
            $aHeaders['Connection ID'] = 'id';
            $aHeaders[MAX_Plugin_Translation::translate('Conversion Date / Time', $this->module, $this->package)] = 'datetime';

            if (!empty($aTracker['variables'])) {
                foreach ($aTracker['variables'] as $trackerVariableId => $aTrackerVariable) {
                    $variableName = !empty($aTrackerVariable['tracker_variable_description']) ? $aTrackerVariable['tracker_variable_description'] : $aTrackerVariable['tracker_variable_name'];
                    // Don't display if the user is a publisher and the variable is hidden
                    if (!phpAds_isUser(phpAds_Publisher) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
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

            $aHeaders['Approval Status'] = 'text';
            $aHeaders['Comment'] = 'text';

            if ($this->shouldDisplaySourceField()) {
                $aHeaders['Source'] = 'text';
            }

            $aHeaders[MAX_Plugin_Translation::translate('Advertiser Name', $this->module, $this->package)] = 'text';
            $aHeaders['Tracker Name'] = 'text';
            $aHeaders['Ad Name'] = 'text';
            $aHeaders[MAX_Plugin_Translation::translate('Publisher Name', $this->module, $this->package)] = 'text';
            $aHeaders['Zone Name'] = 'text';
            $aHeaders['Connection Type'] = 'text';
            $aHeaders['Connection Date / Time'] = 'datetime';
            $aHeaders['IP Address'] = 'text';
            $aHeaders['Country'] = 'text';
            $aHeaders['Domain'] = 'text';
            $aHeaders['Language'] = 'text';
            $aHeaders['OS'] = 'text';
            $aHeaders['Browser'] = 'text';
            $aHeaders['Window Delay'] = 'text';

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
                            if (!phpAds_isUser(phpAds_Publisher) || $aTrackerVariable['tracker_variable_hidden'] != 't') {
                                $value = $aConnection['variables'][$trackerVariableId]['tracker_variable_value'];
                                if ($aTrackerVariable['tracker_variable_data_type'] == 'date') {
                                    // Change value to match Excel format
                                    $value = $this->_report_writer->convertToDate($value);
                                }
                                $aData[$row][] = $value;
                            }
                        }
                    }
                    $aData[$row][] = $this->decodeConnectionStatus($aConnection['connection_status']);
                    $aData[$row][] = $aConnection['connection_comments'];
                    if ($this->shouldDisplaySourceField()) {
                        $aData[$row][] = $aConnection['connection_channel'];
                    }
                    $aData[$row][] = MAX_getAdvertiserName($aConnection['advertiser_name'], null, $trackerAnonymous, $aConnection['advertiser_id']);
                    $aData[$row][] = $trackerName;
                    $aData[$row][] = MAX_getAdName($aConnection['ad_name'], $aConnection['ad_alt'], null, $trackerAnonymous, $aConnection['ad_id']);
                    $aData[$row][] = MAX_getPublisherName($aConnection['publisher_name'], null, $trackerAnonymous, $aConnection['publisher_id']);
                    $aData[$row][] = MAX_getZoneName($aConnection['zone_name'], null, $trackerAnonymous, $aConnection['zone_id']);
                    $aData[$row][] = $this->decodeConnectionType($aConnection['connection_action']);
                    $aData[$row][] = $aConnection['connection_date_time'];
                    $aData[$row][] = $aConnection['connection_ip_address'];
                    $aData[$row][] = $aConnection['connection_country'];
                    $aData[$row][] = (phpAds_isUser(phpAds_Advertiser) && $trackerAnonymous) ? '' : $aConnection['connection_domain'];
                    $aData[$row][] = $aConnection['connection_language'];
                    $aData[$row][] = $aConnection['connection_os'];
                    $aData[$row][] = $aConnection['connection_browser'];
                    $aData[$row][] = $aConnection['window_delay'];
                    $row++;
                }
            }

            $this->_report_writer->createReportSection($worksheetName, $trackerName, $aHeaders, $aData, 30);
        }
    }

    function addPerformanceSheet()
    {
        $worksheetName = MAX_Plugin_Translation::translate('Performance by Day', $this->module, $this->package);
        $this->_report_writer->createReportWorksheet($worksheetName, $this->_name, $this->getReportParametersForDisplay());

        require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsControllerFactory.php';

        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['breakdown'] = 'day';

        if (phpAds_isUser(phpAds_Admin|phpAds_Agency)) {
            if (!empty($this->_scope->_advertiserId) && !empty($this->_scope->_publisherId)) {
                $controller_type = 'advertiser-affiliate-history';
            } elseif (!empty($this->_scope->_advertiserId)) {
                $controller_type = 'advertiser-history';
            } elseif (!empty($this->_scope->_publisherId)) {
                $controller_type = 'affiliate-history';
            } else {
                $controller_type = 'global-history';
            }
        } elseif (phpAds_isUser(phpAds_Client)) {
            if (!empty($this->_scope->_publisherId)) {
                $controller_type = 'advertiser-affiliate-history';
            } else {
                $controller_type = 'advertiser-history';
            }
        } else {
            $controller_type = 'affiliate-history';
        }

        if (!empty($this->_scope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_scope->_advertiserId;
        }
        if (!empty($this->_scope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_scope->_publisherId;
        }

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->_report_writer->createReportSection($worksheetName, $worksheetName, $aHeaders, $aData, 30);
    }

    function prepareTrackerSummaryForDisplay($oDaySpan, $aTrackers)
    {
        $aDays = $oDaySpan->getDayArray();
        $aTrackerSummary = array();
        foreach ($aTrackers as $trackerId => $aConnections) {

            foreach ($tracker_by_day as $day_summary) {
                $day_display = array();
                $day_display[] = $day_summary['day'];
                $day_display[] = $this->decodeConnectionType($day_summary['action']);
                $day_display[] = $day_summary['total_count'];
                $day_display[] = $day_summary['approved_count'];
                $day_display[] = $day_summary['approved_ratio'];
                $tracker_display[] = $day_display;
            }
            $all_trackers_display[$tracker_name] = $tracker_display;
        }
        return $all_trackers_display;
    }

    /**
     * Publishers should not see basket-value variables.
     *
     * @param TrackerVariable $variable
     * @todo Consider moving this to the TrackerVariable class
     */
    function shouldDisplayVariable($variable)
    {
        if (phpAds_isUser(phpAds_Publisher) && $variable->hidden) {
            return false;
        }
        return true;
    }

    function shouldDisplaySourceField()
    {
        if (phpAds_isUser(phpAds_Advertiser)) {
            return false;
        }
        return true;
    }


    function decodeConnectionType($code)
    {
        switch ($code)
        {
            case MAX_CONNECTION_AD_IMPRESSION:
                return 'Impression';
            case MAX_CONNECTION_AD_CLICK:
                return 'Click';
            case MAX_CONNECTION_AD_MANUAL:
                return 'Manual';
            case MAX_CONNECTION_AD_ARRIVAL:
                return 'Arrival';
        }
        return 'Unknown';
    }

    function getConnectionStatuses()
    {
        if (phpAds_isUser(phpAds_Affiliate) && phpAds_isAllowed(MAX_AffiliateViewOnlyApprPendConv)) {
            $aStatus = array(
                MAX_CONNECTION_STATUS_PENDING => 'Pending',
                MAX_CONNECTION_STATUS_APPROVED => 'Approved',
            );
        } else {
            $aStatus = array(
                MAX_CONNECTION_STATUS_PENDING => 'Pending',
                MAX_CONNECTION_STATUS_APPROVED => 'Approved',
                MAX_CONNECTION_STATUS_DUPLICATE => 'Duplicate',
                MAX_CONNECTION_STATUS_DISAPPROVED => 'Disapproved',
                MAX_CONNECTION_STATUS_ONHOLD => 'On Hold',
                MAX_CONNECTION_STATUS_IGNORE => 'Ignore',
            );
        }

        return $aStatus;
    }
    function decodeConnectionStatus($code)
    {
        $aStatus = $this->getConnectionStatuses();
        return $aStatus[$code];
    }

    function getReportParametersForDisplay()
    {
        $aParams = array();
        $aParams += $this->getDisplayableParametersFromScope($this->_scope);
        $aParams += $this->getDisplayableParametersFromDaySpan($this->_daySpan);
        return $aParams;
    }
}

?>
