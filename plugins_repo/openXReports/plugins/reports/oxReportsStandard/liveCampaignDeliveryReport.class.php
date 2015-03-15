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
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';

/**
 * A plugin to generate a report showing conversion tracking information,
 * for the supplied date range. The report contains a single worksheet:
 *
 * 1. Campaign Delivery:
 *  - A breakdown of all campaigns where the campaign has booked impressions, showing
 *    details of the campaign, how much of the campaign has been delivered so far, and,
 *    where start/end dates for the campaign exist, how well the campaign is delivering.
 *
 * @TODO Consider extending the report to also cover booked clicks and conversions.
 *
 * @TODO Consider replacing the calculations in this report with better values derived
 *       from the MPE.
 *
 * @package    OpenXPlugin
 * @subpackage Reports
 */
class Plugins_Reports_OxReportsStandard_LiveCampaignDeliveryReport extends Plugins_ReportsScope
{

    /**
     * The local implementation of the initInfo() method to set all of the
     * required values for this report.
     */
    function initInfo()
    {
        $this->_name         = $this->translate("Campaign Delivery Report");
        $this->_description  = $this->translate("This report shows delivery statistics for all campaigns which were live during the specified period, highlighting campaigns which are underperforming.");
        $this->_category     = 'standard';
        $this->_categoryName = $this->translate("Standard Reports");
        $this->_author       = 'Scott Switzer';
        $this->_export       = 'xls';
        $this->_authorize    = array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

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
                'title'            => $this->translate("Period"),
                'type'             => 'date-month',
                'default'          => $default_period_preset
            ),
            'scope'  => array(
                'title'            => $this->translate("Limitations"),
                'type'             => 'scope',
                'scope_advertiser' => $default_scope_advertiser,
                'scope_publisher'  => $default_scope_publisher
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
     * @param OA_Admin_DaySpan       $oDaySpan The OA_Admin_DaySpan object for the report.
     * @param OA_Admin_Reports_Scope $oScope   ???
     */
    function execute($oDaySpan = null, $oScope = null)
    {
        // Save the scope for use later
        $this->_oScope = $oScope;
        // Prepare the range information for the report
        $this->_prepareReportRange($oDaySpan);
        // Prepare the report name
        $reportFileName = $this->_getReportFileName();
        // Prepare the output writer for generation
        $this->_oReportWriter->openWithFilename($reportFileName);
        // Add the worksheets to the report, as required
        $this->_addSummaryWorksheet();
        // Close the report writer and send the report to the user
        $this->_oReportWriter->closeAndSend();
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
     * A private method to create and add the "campaign delivery" worksheet
     * of the report.
     *
     * @access private
     */
    function _addSummaryWorksheet()
    {
        // Prepare the headers for the worksheet
        $aHeaders = array();
        $key = $GLOBALS['strCampaignName'];
        $aHeaders[$key] = 'text';
        $key = $this->translate("Type");
        $aHeaders[$key] = 'text';
        $key = $GLOBALS['strStatus'];
        $aHeaders[$key] = 'text';
        $key = $GLOBALS['strPriority'];
        $aHeaders[$key] = 'text';
        $key = $GLOBALS['strStartDate'];
        $aHeaders[$key] = 'date';
        $key = $GLOBALS['strEndDate'];
        $aHeaders[$key] = 'date';
        $key = $this->translate("Booked Impressions");
        $aHeaders[$key] = 'number';
        $key = $this->translate("Delivered Impressions");
        $aHeaders[$key] = 'number';
        $key = $this->translate("% Complete");
        $aHeaders[$key] = 'percent';
        $key = $this->translate("Overall +/-");
        $aHeaders[$key] = 'percent';
        $key = $this->translate("Current +/-");
        $aHeaders[$key] = 'percent';
        // Get the raw data for the worksheet
        $aData = $this->_getDeliveryPerformanceData();
        // Format the raw data ready for display
        $aData = $this->_prepareDeliveryPerformanceData($aData);
        // Add the worksheet
        $this->createSubReport(
            $GLOBALS['strCampaignDelivery'],
            $aHeaders,
            $aData
        );
    }

    /**
     * A private method to retrieve the campaign delivery performance statistics for report's
     * date range, as well as for "yesterday" and "today", and to return the combined data.
     *
     * @access private
     * @return array
     */
    function _getDeliveryPerformanceData()
    {
        // Get the report period raw performance data, using UTC time
        $oSpan = new OA_Admin_DaySpan();
        $oSpan->setSpanDays($this->_oDaySpan->oStartDate, $this->_oDaySpan->oEndDate);
        $oSpan->toUTC();
        $aReportData    = $this->_getDeliveryPerformanceDataRange($this->_oScope, $oSpan, true);
        // Get the raw performance data for "yesterday", using UTC time
        $oSpanYesterday = new OA_Admin_DaySpan('yesterday');
        $oSpanYesterday->toUTC();
        $aYesterdayData = $this->_getDeliveryPerformanceDataRange($this->_oScope, $oSpanYesterday);
        // Get the raw performance data for "today", using UTC time
        $oSpanToday = new OA_Admin_DaySpan('today');
        $oSpanToday->toUTC();
        $aTodayData = $this->_getDeliveryPerformanceDataRange($this->_oScope, $oSpanToday);
        // Merge the above data, injecting today's delivery at the same time,
        // using normal time, as the merge process will convert to UTC time
        $oSpanYesterday = new OA_Admin_DaySpan('yesterday');
        $oSpanToday = new OA_Admin_DaySpan('today');
        $aData = $this->_mergeDeliveryPerformanceData($aReportData, $aYesterdayData, $oSpanYesterday, $aTodayData, $oSpanToday);
        return $aData;
    }

    /**
     * A private method to obtain the raw delivery performance data for a given date range.
     *
     * @access private
     * @param Admin_UI_OrganisationScope $oScope The Admin_UI_OrganisationScope limitation object for
     *                                           the report.
     * @param OA_Admin_DaySpan $oDaySpan The OA_Admin_DaySpan day range limitation object for the report,
     *                                   or for "yesterday" or "today" as required.
     * @param boolean $spanIsForPlacementDates If true, $oDaySpan is used for the start/end date limitaion
     *                                         of the placements, otherwise it is used to limit the
     *                                         data to delivery that happened in the $oDaySpan range.
     * @return array
     */
    function _getDeliveryPerformanceDataRange($oScope, $oDaySpan, $spanIsForPlacementDates = false, $statsTable = false, $appendSqlWhere = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if(empty($appendSqlWhere)) {
            $appendSqlWhere = "AND c.type = ".DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT . " ";
        }
        if($statsTable === false) {
            $statsTable = $aConf['table']['prefix'].$aConf['table']['data_summary_ad_hourly'];
        }
        $advertiserId    = $oScope->getAdvertiserId();
        $publisherId     = $oScope->getPublisherId();
        $agencyId        = $oScope->getAgencyId();
        $query = "
            SELECT
                c.campaignid AS campaign_id,
                c.campaignname AS campaign_name,
                c.priority AS campaign_priority,
                c.status AS campaign_is_active,
                c.activate_time AS campaign_start,
                c.expire_time AS campaign_end,
                c.views AS campaign_booked_impressions,
                SUM(stats.impressions) AS campaign_impressions,
                MAX(stats.date_time) AS stats_most_recent_date_time
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['campaigns']} AS c,
                {$aConf['table']['prefix']}{$aConf['table']['banners']} AS b,
                ".$statsTable." AS stats";
        if ($publisherId) {
            $query .= ",
                {$aConf['table']['prefix']}{$aConf['table']['zones']} AS z";
        }
        if ($agencyId) {
            $query .= ",
                {$aConf['table']['prefix']}{$aConf['table']['clients']} AS a";
        }
        $query .= "
            WHERE
                c.campaignid = b.campaignid
				". $appendSqlWhere ."
				AND
                b.bannerid = stats.ad_id";
        if ($spanIsForPlacementDates) {
            $query .= "
                AND
                (
                    c.activate_time <= " . DBC::makeLiteral($oDaySpan->getEndDateStringUTC(), 'string') . "
                    OR
                    c.activate_time IS NULL
                )
                AND
                (
                    c.expire_time >= " . DBC::makeLiteral($oDaySpan->getStartDateStringUTC(), 'string') . "
                    OR
                    c.expire_time IS NULL
                )";
        } else {
            $query .= "
                AND
                stats.date_time >= " . DBC::makeLiteral($oDaySpan->getStartDateStringUTC(), 'string') . "
                AND
                stats.date_time <= " . DBC::makeLiteral($oDaySpan->getEndDateStringUTC(), 'string') . "
            ";
        }
        if ($advertiserId) {
            $query .= "
                AND
                c.clientid = " . DBC::makeLiteral($advertiserId, 'integer');
        }
        if ($publisherId) {
            $query .= "
                AND
                stats.zone_id = z.zoneid
                AND
                z.affiliateid = " . DBC::makeLiteral($publisherId, 'integer');
        }
        if ($agencyId) {
            $query .= "
                AND
                c.clientid = a.clientid
                AND
                a.agencyid = " . DBC::makeLiteral($agencyId, 'integer');
        }
        $query .= "
            GROUP BY
                campaign_id,
                campaign_name,
                campaign_priority,
                campaign_is_active,
                campaign_start,
                campaign_end,
                campaign_booked_impressions
            ORDER BY
                campaign_impressions";
        $rsDeliveryPerformanceData = DBC::NewRecordSet($query);
        $rsDeliveryPerformanceData->find();
        $aDeliveryPerformanceData = $rsDeliveryPerformanceData->getAll();

        return $aDeliveryPerformanceData;
    }

    /**
     * Take impressions from today's/yesterday's statistics and use them to augment the overall statistics.
     *
     * This step is only necessary because the underlying query builder is incapable of
     * joining a table to itself, which would be necessary to gather today's impressions
     * at the same time as those for the whole period.
     *
     * @access private
     * @param array $aReportData The result of
     *                           {@link Plugins_Reports_Standard_LiveCampaignDeliveryReport::_getDeliveryPerformanceDataRange()}
     *                           for the report period.
     * @param array $aYesterdayData The result of
     *                              {@link Plugins_Reports_Standard_LiveCampaignDeliveryReport::_getDeliveryPerformanceDataRange()}
     *                              for "yesterday".
     * @param OA_Admin_DaySpan $oSpanYesterday The OA_Admin_DaySpan object for "yesterday".
     * @param array $aTodayData The result of
     *                          {@link Plugins_Reports_Standard_LiveCampaignDeliveryReport::_getDeliveryPerformanceDataRange()}
     *                          for "today".
     * @param OA_Admin_DaySpan $oSpanToday The OA_Admin_DaySpan object for "today".
     * @return array An array of campaign information as per the $aReportData array, but also
     *               including 'yesterdays_impressions' and 'todays_impressions', as well as
     *               an hourly breakdown of "yesterday's" and "today's" impressions in hourly
     *               format in 'yesterdays_impressions_by_hour' and 'todays_impressions_by_hour'.
     */
    function _mergeDeliveryPerformanceData($aReportData, $aYesterdayData, $oSpanYesterday, $aTodayData, $oSpanToday)
    {
        $aData = array();
        foreach ($aReportData as $aCampaignData)
        {
            $campaignId = $aCampaignData['campaign_id'];
            // Add yesterday's impressions to the campaign report period data
            $aCampaignDataYesterday = $this->_findMatchingCampaignData($campaignId, $aYesterdayData);
            $yesterdaysImpressions  = $aCampaignDataYesterday['campaign_impressions'];
            $aCampaignData['yesterdays_impressions'] = $yesterdaysImpressions;
            // Get and add yesterday's impressions by hour
            $yesterdayDateString = $oSpanYesterday->getStartDateString();
            $aYesterdaysImpressionsByHour = Admin_DA::getHourHistory(
                array(
                    'placement_id' => $campaignId,
                    'day_begin'    => $yesterdayDateString,
                    'day_end'      => $yesterdayDateString
                )
            );
            $aCampaignData['yesterdays_impressions_by_hour'] = $aYesterdaysImpressionsByHour;
            // Add today's impressions to the campaign report period data
            $aCampaignDataToday = $this->_findMatchingCampaignData($campaignId, $aTodayData);
            $todaysImpressions  = $aCampaignDataToday['campaign_impressions'];
            $aCampaignData['todays_impressions'] = $todaysImpressions;
            // Get and add today's impressions by hour
            $todayDateString = $oSpanToday->getStartDateString();
            $aTodaysImpressionsByHour = Admin_DA::getHourHistory(
                array(
                    'placement_id' => $campaignId,
                    'day_begin'    => $todayDateString,
                    'day_end'      => $todayDateString
                )
            );
            $aCampaignData['todays_impressions_by_hour'] = $aTodaysImpressionsByHour;
            // Add the newly merged data for this campaign to the return array
            $aData[] = $aCampaignData;
        }
        return $aData;
    }

    /**
     * A private method to find campaign delivery performance information in an
     * unordered array resulting from a call to
     * {@link Plugins_Reports_Standard_LiveCampaignDeliveryReport::_getDeliveryPerformanceDataRange()}.
     *
     * @access private
     * @param integer $campaignId The campaign ID to search for.
     * @param array $aData An array of campaign delivery performance information arrays from a
     *                     call to
     *                     {@link Plugins_Reports_Standard_LiveCampaignDeliveryReport::_getDeliveryPerformanceDataRange()}.
     * @return array The matching campaign information array, if found; an empty array otherwise.
     */
    function _findMatchingCampaignData($campaignId, $aData)
    {
        foreach ($aData as $aCampaignData) {
            if ($aCampaignData['campaign_id'] == $campaignId) {
                return $aCampaignData;
            }
        }
        return array();
    }

    /**
     * A private method to organise named campaign data into appropriately ordered
     * columns, ready for display.
     *
     * Several columns only make sense for campaigns with impression targets
     * (ie, high priority campaigns) so they will appear blank for campaigns
     * without targets.
     *
     * @access private
     * @param array $aData
     * @return array
     */
    function _prepareDeliveryPerformanceData($aData)
    {
        $aDisplayData = array();
        foreach ($aData as $aCampaignData) {
            $aCampaignDisplayData = array();
            $campaignId = $aCampaignData['campaign_id'];
            $aCampaignDisplayData[] = $aCampaignData['campaign_name'];
            $aCampaignDisplayData[] = $this->_calculateCampaignType($campaignId);
            $aCampaignDisplayData[] = $this->_decodeStatusDescription($aCampaignData['campaign_is_active']);
            $aCampaignDisplayData[] = $this->_decodePriority($aCampaignData['campaign_priority']);
            $aCampaignDisplayData[] = $this->_formatDateForDisplay($aCampaignData['campaign_start']);
            $aCampaignDisplayData[] = $this->_formatDateForDisplay($aCampaignData['campaign_end']);
            if ($aCampaignData['campaign_booked_impressions'] == -1)
                $aCampaignData['campaign_booked_impressions'] = '-';
            $aCampaignDisplayData[] = $aCampaignData['campaign_booked_impressions'];
            $aCampaignDisplayData[] = $aCampaignData['campaign_impressions'];
            if ($aCampaignData['campaign_priority'] > 0) {
                // Campaign is a high priority campaign...
                $aCampaignDisplayData[] = $this->_calculateCompletionPercentage($aCampaignData);
                $aCampaignDisplayData[] = $this->_calculateOverallMisdelivery($aCampaignData);
                $aCampaignDisplayData[] = $this->_calculateTodaysMisdelivery($aCampaignData);
            } else {
                // Campaign is either override or remnant
                $aCampaignDisplayData[] = false;
                $aCampaignDisplayData[] = false;
                $aCampaignDisplayData[] = false;
            }
            $aDisplayData[] = $aCampaignDisplayData;
        }
        return $aDisplayData;
    }

    /**
     * A private method to calculate the appropriate label for the
     * "campaign type".
     *
     * Possible values are:
     *  - 'Run of site' (if there are no limitations set
     *     for any of the adverts linked to the campaign)
     *  - 'Targeted' (if when there are any limitations
     *     for any of the adverts linked to the campaign)
     *
     * @access private
     * @param integer $campaignId The campaign ID.
     * @return string The translated label for the campaign type.
     */
    function _calculateCampaignType($campaignId)
    {
        $dalCampaigns = OA_Dal::factoryDAL('campaigns');
        $isTargeted = $dalCampaigns->isTargeted($campaignId);
        if ($isTargeted) {
            $type = $this->translate("Targeted");
        } else {
            $type = $this->translate("Run of Site");
        }
        return $type;
    }

    /**
     * A private method to decode the selected "campaign_is_active" value into
     * a string for display in the report.
     *
     * @access private
     * @param string $isActive The selected "campaign_is_active" value.
     * @return string The appropriate return string for the value
     */
    function _decodeStatusDescription($isActive)
    {
        if ($isActive == OA_ENTITY_STATUS_RUNNING) {
            $type = $this->translate("Running");
        } else {
            $type = $this->translate("Stopped");

        }
        return $type;
    }

    /**
     * A private method to decode the selected "campaign_priority" value into
     * a string for display in the report.
     *
     * @access private
     * @param string $priorityCode The selected "campaign_priority" value.
     * @return string The appropriate return string for the value
     */
    function _decodePriority($priorityCode)
    {
        if ($priorityCode == -1) {
            $type = $this->translate("Override");
        } else if ($priorityCode == 0) {
            $type = $this->translate("Remnant");
        } else {
            $type = $this->translate("Contract");
        }
        return $type;
    }

    /**
     * A private method for formatting date strings for the report.
     *
     * @access private
     * @param string $dateString The date in string format to format.
     * @return string The formatting date string for the report, or false if
     *                the date should not be shown.
     */
    function _formatDateForDisplay($dateString)
    {
        if (empty($dateString)) {
            return false;
        }
        global $date_format;
        $oDate = new Date($dateString);
        $oTz = $oDate->tz;
        $oDate->setTZbyID('UTC');
        $oDate->convertTZ($oTz);
        $formattedDate = $oDate->format($date_format);
        return $formattedDate;
    }

    /**
     * A private method to calculate the percentage of a high priority campaign delivered so far.
     *
     * @access private
     * @param array $aCampaignData An array of campaign data.
     * @return float The percentage (between 0.00 and 100.00) of the campaign delivered so far.
     */
    function _calculateCompletionPercentage($aCampaignData)
    {
        $delivered = $aCampaignData['campaign_impressions'];
        $target = $aCampaignData['campaign_booked_impressions'];
        if (($delivered > 0) && ($target > 0)) {
            return ($delivered / $target);
        }
        return false;
    }

    /**
     * A private method to calculate an approximate value of how badly a
     * high-priority campaign is mis-delivering so far over the campaign's
     * lifetime.
     *
     * @access private
     * @param array $aCampaignData An array of campaign data.
     * @return float The difference in actual percentage of the campaign's delivered impressions and the
     *               desired precentage of the campaign's delivered impressions. Positive for over-delivery,
     *               negative for under-delivery.
     */
    function _calculateOverallMisdelivery($aCampaignData)
    {
        // Only calculate mis-delivery if start and end dates present
        if (empty($aCampaignData['campaign_start']) || empty($aCampaignData['campaign_end'])) {
            return false;
        }

        // Calculate the number of days the campaign should run over
        $oCampaignDaySpan =& $this->_rangeFromCampaign($aCampaignData);
        $campaignDays = $oCampaignDaySpan->getDaysInSpan();

        // Calulate the number of days over which the campaign has been running
        $oCampaignRunningDaySpan = new OA_Admin_DaySpan();
        $oBeginDate = new Date($aCampaignData['campaign_start']);
        $oEndDate   = new Date($aCampaignData['stats_most_recent_day']);
        $oCampaignRunningDaySpan->setSpanDays($oBeginDate, $oEndDate);
        $runningDays = $oCampaignRunningDaySpan->getDaysInSpan() - 1;

        if ($runningDays <= 0) {
            // The campaign has not started running yet
            $percentDiff = 0;
            return $percentDiff;
        }

        // Ensure the number of days the campaign has been running for makes sense
        if ($runningDays > $campaignDays) {
            // The campaign has been running longer than it was expected to!
            $runningDays = $campaignDays;
        }

        // Calculate how many impressions were delivered up until the end
        // of "yesterday"
        $campaignImpressionsToLastNight = $aCampaignData['campaign_impressions'] - $aCampaignData['todays_impressions'];

        // Calculate the percent difference and return
        $percentDiff = $this->_calculateOverallPercentDifference(
            $campaignDays,
            $runningDays,
            $aCampaignData['campaign_booked_impressions'],
            $campaignImpressionsToLastNight
        );
        return $percentDiff;
    }

    /**
     * A private method to calculate an approximate value of how badly a
     * high-priority campaign is mis-delivering so far "today".
     *
     * @access private
     * @param array $aCampaignData An array of campaign data.
     * @return float The difference in the predicted final delivered impressions of a high-priority
     *               campaign (based on "today's" data) and booked number of impressions the campaign
     *               has. Positive for over-delivery, negative for under-delivery.
     */
    function _calculateTodaysMisdelivery($aCampaignData)
    {
        // Only calculate mis-delivery if start and end dates present
        if (empty($aCampaignData['campaign_start']) || empty($aCampaignData['campaign_end'])) {
            return false;
        }

        // Calculate the number of days the campaign should run over
        $oCampaignDaySpan =& $this->_rangeFromCampaign($aCampaignData);
        $campaignDays = $oCampaignDaySpan->getDaysInSpan();

        // Calulate the number of days over which the campaign has been running
        $oCampaignRunningDaySpan = new OA_Admin_DaySpan();
        $oBeginDate = new Date($aCampaignData['campaign_start']);
        $oEndDate   = new Date($aCampaignData['stats_most_recent_day']);
        $oCampaignRunningDaySpan->setSpanDays($oBeginDate, $oEndDate);
        $runningDays = $oCampaignRunningDaySpan->getDaysInSpan() - 1;

        if ($runningDays <= 0) {
            // The campaign has not started running yet
            $percentDiff = 0;
            return $percentDiff;
        }

        // Ensure the number of days the campaign has been running for makes
        // sense, and also set the number or hours that the campaign has been
        // running for "today"
        if ($runningDays > $campaignDays) {
            // The campaign has been running longer than it was expected to!
            $runningDays = $campaignDays;
            $runningHours = 0;
        } else {
            $runningHours = $aCampaignData['stats_most_recent_hour'];
        }

        // Calculate how many impressions were delivered "yesterday" up to the same point
        // in time as we are at "now"
        $counter = 1;
        $yesterdaysImpressionsToSameHourAsNow = 0;
        foreach ($aCampaignData['yesterdays_impressions_by_hour'] as $aHour) {
            if ($counter > $runningHours) {
                // Have gone past the same hour as "now", stop adding
                break;
            }
            $yesterdaysImpressionsToSameHourAsNow += $aHour['campaign_impressions'];
        }

        // Calculate how many days are remaining for the campaign
        $remainingDays = $campaignDays - $runningDays;

        // Calculate how many impressions were delivered up until the end
        // of "yesterday"
        $campaignImpressionsToLastNight = $aCampaignData['campaign_impressions'] - $aCampaignData['todays_impressions'];

        // Calculate the percent difference and return
        $percentDiff = $this->_calculateTodaysPercentDifference(
            $aCampaignData['todays_impressions'],
            $aCampaignData['yesterdays_impressions'],
            $yesterdaysImpressionsToSameHourAsNow,
            $remainingDays,
            $campaignImpressionsToLastNight,
            $aCampaignData['campaign_booked_impressions']
        );
        return $percentDiff;
    }

    /**
     * A private method to create an OA_Admin_DaySpan object with the campaign's
     * start and end date values.
     *
     * @access private
     * @param array $aCampaignData An array of campaign data.
     * @return OA_Admin_DaySpan The date range of the campaign's activation date and
     *                          expiry date.
     */
    function &_rangeFromCampaign($aCampaignData)
    {
        $oCampaignDaySpan = new OA_Admin_DaySpan();
        $oDate = new Date();
        $oBeginDate = new Date($aCampaignData['campaign_start']);
        $oEndDate   = new Date($aCampaignData['campaign_end']);
        $oBeginDate->setTzByID('UTC');
        $oEndDate->setTzByID('UTC');
        $oBeginDate->convertTZ($oDate->tz);
        $oEndDate->convertTZ($oDate->tz);
        $oCampaignDaySpan->setSpanDays($oBeginDate, $oEndDate);
        return $oCampaignDaySpan;
    }

    /**
     * A private method to calculate the difference in actual percentage of a high-priority
     * campaign's delivered impressions and desired precentage of campaign's delivered
     * impressions.
     *
     * @access private
     * @param integer $campaignDays The number of days the campaign is expected to run for.
     * @param integer $runningDays The number of days the campaign has been running for.
     * @param integer $desiredImpressions The number of impressions the campaign has been booked to deliver.
     * @param integer $actualImpressions The number of impressions the campaign has delivered so far.
     * @return float The difference in actual percentage of the campaign's delivered impressions and the
     *               desired precentage of the campaign's delivered impressions. Positive for over-delivery,
     *               negative for under-delivery.
     */
    function _calculateOverallPercentDifference($campaignDays, $runningDays, $desiredImpressions, $actualImpressions)
    {
        // The expected campaign delivery percentage is the number of days the campaign has been
        // running divided by the total campaign lifetime, assuming even daily delivery
        $expectedPercentDelivered = ($runningDays / $campaignDays) * 100;
        // The actual campaign delivery percentage is the number of impressions delivered
        // divided by the number of impressions booked
        $actualPercentDelivered = ($actualImpressions / $desiredImpressions) * 100;
        // Calculate and return the percentage difference
        $percentDiff = $actualPercentDelivered - $expectedPercentDelivered;
        return $percentDiff;
    }

    /**
     * A private method to calculate the difference in the predicted final delivered impressions
     * of a high-priority campaign (based on "today's" data) and booked number of impressions the
     * campaign has.
     *
     * @access private
     * @param integer $campaignDays The number of days the campaign is expected to run for.
     * @param integer $runningDays The number of days the campaign has been running for.
     * @param integer $desiredImpressions The number of impressions the campaign has been booked to deliver.
     * @param integer $actualImpressions The number of impressions the campaign has delivered so far.
     * @return float The difference in the predicted final delivered impressions of a high-priority
     *               campaign (based on "today's" data) and booked number of impressions the campaign
     *               has. Positive for over-delivery, negative for under-delivery.
     */
    function _calculateTodaysPercentDifference($todaysImpressions, $yesterdaysImpressions, $yesterdaysImpressionsToSameHourAsNow, $remainingDays, $campaignImpressionsToLastNight, $desiredImpressions)
    {
        // The number of impressions that are predicted to happen "today" is the number of impressions delivered so
        // far today, multiplied by the total number of impressions delivered yesterday divided by how many of those
        // impressions had been delivered so far at the same point in time yesterday
        $predictedImpressionsToday = $todaysImpressions * ($yesterdaysImpressions / $yesterdaysImpressionsToSameHourAsNow);
        // At this predicted daily rate of delivery, the total impressions that will be delivered is this number
        // of impressions multiplied by the days remaining for the campaign, plus how many impressions have been
        // delivered before today
        $predictedTotalImpressions = ($predictedImpressionsToday * $remainingDays) + $campaignImpressionsToLastNight;
        // Calculate and return the percentage difference
        $percentDiff = (($predictedTotalImpressions / $desiredImpressions) - 1) * 100;
        return $percentDiff;
    }

}

?>