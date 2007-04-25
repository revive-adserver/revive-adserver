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
require_once MAX_PATH . '/lib/max/DaySpan.php';

class Plugins_Reports_Standard_LiveCampaignDeliveryReport extends EnhancedReport
{
    function initInfo()
    {
        $this->_name = 'Campaign Delivery Report';
        $this->_description = 'This report shows delivery statistics for all campaigns which were live during the specified period, highlighting campaigns which are underperforming.';
        $this->_category = 'standard';
        $this->_categoryName = 'Standard Reports';
        $this->_authorize = phpAds_Admin + phpAds_Agency;

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
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
            'scope_advertiser' => $default_scope_advertiser,
            'scope_publisher' => $default_scope_publisher
        );

        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        $aImport['period'] = array(
            'title' => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
            'type' => 'date-month',
            'default' => $default_period_preset
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

    function getReportParametersForDisplay()
    {
        $aParams = array();
        $aParams = $this->getDisplayableParametersFromScope($this->_scope);
        $aParams += $this->getDisplayableParametersFromDaySpan($this->_daySpan);
        return $aParams;
    }

    function execute($scope, $oDaySpan)
    {
        $this->_daySpan = $oDaySpan;
        $this->_scope = $scope;

        $startDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getStartDateString())): 'Beginning';
        $endDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getEndDateString())): date('Y-M-d');
        $reportName = $this->_name . ' from ' . $startDate . ' to ' . $endDate . '.xls';

        $this->_report_writer->openWithFilename($reportName);
        $this->addSummarySheet();
        $this->_report_writer->closeAndSend();
    }

    function addSummarySheet()
    {
        $headers = array(
            'Campaign Name' => 'text',
            'Type' => 'text',
            'Status' => 'text',
            'Priority' => 'text',
            'Start Date' => 'date',
            'End Date' => 'date',
            'Booked Views' => 'number',
            'Delivered Views' => 'number',
            '% Complete' => 'percent',
            'Overall +/-' => 'percent',
            'Current +/-' => 'percent'
        );
        $delivery_data = $this->getDeliveryData();
        $delivery_display = $this->prepareCampaignDeliveryForDisplay($delivery_data);
        $this->createSubReport('Campaigns', $headers, $delivery_display);
    }

    /**
     * Organises named campaign data into appropriately ordered columns.
     *
     * Several columns only make sense for campaigns with impression targets
     * (ie, high priority campaigns) so they will appear blank for campaigns
     * without targets.
     *
     * @param array $campaigns Array of campaign-data arrays
     *
     * @return array of arrays Ready for output to report writers
     */
    function prepareCampaignDeliveryForDisplay($campaigns)
    {
        $campaigns_display = array();
        foreach ($campaigns as $campaign) {
            $campaign_display = array();
            $campaign_display[] = $campaign['campaign_name'];
            $campaign_display[] = $this->calculateCampaignType($campaign);
            $campaign_display[] = $this->decodeStatusDescription($campaign['campaign_is_active']);
            $campaign_display[] = $this->decodePriority($campaign['campaign_priority']);
            $campaign_display[] = $this->formatDateForDisplay($campaign['campaign_start']);
            $campaign_display[] = $this->formatDateForDisplay($campaign['campaign_end']);
            $campaign_display[] = $campaign['campaign_booked_views'];
            $campaign_display[] = $campaign['campaign_impressions'];
            if ($this->isCampaignHighPriority($campaign)) {
                $campaign_display[] = $this->calculateCompletionPercentage($campaign);
                $campaign_display[] = $this->calculateOverallMisdelivery($campaign);
                $campaign_display[] = $this->calculateTodaysMisdelivery($campaign);
            } else {
                $campaign_display[] = false;
                $campaign_display[] = false;
                $campaign_display[] = false;
            }

            $campaigns_display[] = $campaign_display;
        }
        return $campaigns_display;
    }

    function decodeStatusDescription($is_active)
    {
        if ($is_active == 't') {
            return 'Running'; //FIXME: Translatable string
        }
        return 'Stopped'; //FIXME: Translatable string
    }

    function decodePriority($priority_code)
    {
        if ($priority_code == -1) {
            return '1-exclusive'; //FIXME: Translatable string
        }
        if ($priority_code == 0) {
            return '3-low'; //FIXME: Translatable string
        }
        return '2-high'; //FIXME: Translatable string
    }

    /**
     * Find the appropriate label for "campaign type".
     *
     * Possible values are:
     *    * 'Run of site' (if there are no limitations set
     *      for any of the adverts linked to the campaign)
     *
     *    * 'Targeted' (if when there are any limitations
     *      for any of the adverts linked to the campaign)
     *
     * @param array $campaign
     * @return string A label for Campaign Type.
     *                Either 'Run of site' or 'Targeted'.
     * @todo Integrate this into the live campaign summary DAL call
     */
    function calculateCampaignType($campaign)
    {
        $campaign_id = $campaign['campaign_id'];
        $is_targeted = $this->dal->isCampaignTargeted($campaign_id);
        if ($is_targeted) {
            return 'Targeted'; //FIXME: Translatable string
        } else {
            return 'Run of site'; //FIXME: Translatable string
        }
    }

    /**
     * How many of the requested impressions have been delivered so far, as a proportion?
     *
     * @param array $campaign An array representing campaign information
     * @return float 1.0 when all requested impressions have been delivered.
     */
    function calculateCompletionRatio($campaign)
    {
        $delivered = $campaign['campaign_impressions'];
        $target = $campaign['campaign_booked_views'];

        if (($delivered > 0) && ($target > 0)) {
            return $delivered / $target;
        }
        return false;
    }

    /**
     * How many of the requested impressions have been delivered so far, as a percentage?
     *
     * @param array $campaign An array representing campaign information
     * @return float 100.0 when all requested impressions have been delivered.
     */
    function calculateCompletionPercentage($campaign)
    {
        $delivered = $campaign['campaign_impressions'];
        $target = $campaign['campaign_booked_views'];

        if (($delivered > 0) && ($target > 0)) {
            return ($delivered / $target) * 100;
        }
        return false;
    }

    /**
     * High-priority campaigns have a target for impression delivery, but
     * targets can be missed.
     *
     * @param array $campaign An array representing campaign information
     * @return float Negative on underdelivery, positive on overdelivery
     */
    function calculateOverallMisdelivery($campaign)
    {
        // Only high-priority campaigns have targets, so it doesn't make sense
        // to calculate performance against target for other campaigns
        if (!$this->isCampaignHighPriority($campaign)) {
            return 0;
        }

        $campaign_range =& $this->rangeFromCampaign($campaign);
        $campaign_days = $campaign_range->getDaysInSpan();

        $most_recent_day_string = $campaign['stats_most_recent_day'];
        $most_recent_day = new Date($most_recent_day_string);

        $running_range = new DaySpan();
        $oBeginDate = new Date($campaign['campaign_start']);
        $oEndDate = new Date($most_recent_day_string);
        $running_range->setSpanDays($oBeginDate,$oEndDate);
        $running_days = $running_range->getDaysInSpan() - 1;

        if ($running_days <= 0) {
            return 0;
        }
        if ($running_days > $campaign_days) {
            $running_days = $campaign_days;
            $running_hours = 0;
        } else {
            $running_hours = $campaign['stats_most_recent_hour'];
        }

        $campaign_impressions_to_last_night = $campaign['campaign_impressions'] - $campaign['todays_impressions'];

        $percent_diff = $this->calculateOverallPercentDifference($campaign_days, $running_days, $running_hours, $campaign['campaign_booked_views'], $campaign_impressions_to_last_night);
        return $percent_diff;
    }

    /**
     * @return float positive for over-delivery, negative for under-delivery
     */
    function calculateOverallPercentDifference($campaign_days, $running_days, $running_hours, $desired_impressions, $actual_impressions)
    {
        $expected_impressions_per_day = $desired_impressions / $campaign_days;
        $expected_impressions_to_previous_night = ($expected_impressions_per_day * $running_days);
        $expected_percent_delivered = ($running_days / $campaign_days) * 100;
        $actual_percent_delivered = ($actual_impressions / $desired_impressions) * 100;

        $percent_diff = $actual_percent_delivered - $expected_percent_delivered;
        return $percent_diff;
    }

    /**
     * @param $campaign An array representing campaign information
     * @return float Positive for overdelivery, negative for underdelivery
     */
    function calculateTodaysMisdelivery($campaign)
    {
        // If there's no record of impressions for today,
        // we can't calculate how close it is to target
        if (!($campaign['todays_impressions']) > 0) {
            return false;
        }

        $campaign_range =& $this->rangeFromCampaign($campaign);
        $campaign_days = $campaign_range->getDaysInSpan();

        $most_recent_day_string = $campaign['stats_most_recent_day'];
        $most_recent_day = new Date($most_recent_day_string);

        $running_range = new DaySpan();
        $oBeginDate = new Date($campaign['campaign_start']);
        $oEndDate = new Date($most_recent_day_string);
        $running_range->setSpanDays($oBeginDate,$oEndDate);
        $running_days = $running_range->getDaysInSpan() - 1;

        if ($running_days <= 0) {
            return 0;
        }
        if ($running_days > $campaign_days) {
            $running_days = $campaign_days;
            $running_hours = 0;
        } else {
            $running_hours = $campaign['stats_most_recent_hour'];
        }

        $running_hours = $campaign['stats_most_recent_hour']; // CC - Why is this overriding what we just did?
        $todays_impressions = $campaign['todays_impressions'];
        $campaign_impressions_to_last_night = $campaign['campaign_impressions'] - $todays_impressions;
        $yesterdays_impressions = $campaign['yesterdays_impressions'];
        $yesterdays_impressions_by_hour = $campaign['yesterdays_impressions_by_hour'];
        $today_hours = $campaign_range->_now->hour;

        // work out how many impressions there were at this time yesterday
        $cnt = 1;
        foreach ($yesterdays_impressions_by_hour as $hour) {
            $yesterdays_impressions_at_this_hour += $hour['sum_views'];
            $cnt++;
            if ($cnt > $today_hours) break;
        }

        $remaining_days = $campaign_days - $running_days;

        $percent_diff = $this->calculateTodaysPercentDifference($campaign_impressions_to_last_night, $todays_impressions, $yesterdays_impressions_at_this_hour, $yesterdays_impressions, $remaining_days, $campaign['campaign_booked_views']);

        // if campaign looks set to be fully delivered, return message to that effect
        // else return the predicted % difference
        if ($percent_diff >= 0) {
            return $GLOBALS['strCampaignPredictedFullDeliveryMessage'];
        } else {
            return $percent_diff;
        }
    }

    /**
     * @return float positive for over-delivery, negative for under-delivery
     */
    function calculateTodaysPercentDifference($campaign_impressions_to_last_night, $todays_impressions, $yesterdays_impressions_at_this_hour, $yesterdays_impressions, $remaining_days, $desired_impressions)
    {
        $predicted_daily_volume = ($todays_impressions / $yesterdays_impressions_at_this_hour) * $yesterdays_impressions;
        $predicted_end_volume = $predicted_daily_volume * $remaining_days + $campaign_impressions_to_last_night;
        $percent_diff = (($predicted_end_volume / $desired_impressions) - 1) * 100;

        return $percent_diff;
    }

    /**
     * @return float 1.0 for perfect delivery, 2.0 for double delivery
     */
    function calculateAccuracyRatio($campaign_days, $running_days, $running_hours, $desired_impressions, $actual_impressions)
    {
        $expected_impressions_per_day = $desired_impressions / $campaign_days;
        $expected_impressions_to_previous_night = ($expected_impressions_per_day * $running_days);
        $expected_impressions_today = $expected_impressions_per_day * ($running_hours / 24);
        $expected_impressions_so_far = $expected_impressions_to_previous_night + $expected_impressions_today;

        $accuracy_ratio = $actual_impressions / $expected_impressions_so_far;
        return $accuracy_ratio;
    }

    /**
     * @param array campaign An array representing campaign information
     * @return bool True if the campaign is high-priority
     */
    function isCampaignHighPriority($campaign)
    {
        if ($campaign['campaign_priority'] > 0) {
            return true;
        }
        return false;
    }

    /**
     * @return DaySpan A date range from the campaign's activation date to its expiry date.
     */
    function &rangeFromCampaign($campaign)
    {
        $campaign_range = new DaySpan();
        $oBeginDate = new Date($campaign['campaign_start']);
        $oEndDate = new Date($campaign['campaign_end']);
        $campaign_range->setSpanDays($oBeginDate,$oEndDate);

        return $campaign_range;
    }

    /**
     * Retrieve activity statistics for the date range and for today, then mix them together.
     *
     * @return array Each element is an array representing a campaign.
     */
    function getDeliveryData()
    {
        $today = new DaySpan('today');
        $yesterday = new DaySpan('yesterday');
        $delivery_data_for_period = $this->dal->getCampaignDeliveryPerformanceForScopeByCampaignsActiveWithinPeriod($this->_scope, $this->_period);
        $delivery_data_for_today = $this->dal->getCampaignDeliveryPerformanceForScopeByCampaign($this->_scope, $today);
        $delivery_data_for_yesterday = $this->dal->getCampaignDeliveryPerformanceForScopeByCampaign($this->_scope, $yesterday);
        $combined_delivery_data = $this->injectRecentImpressionsIntoCampaignData($delivery_data_for_period , $delivery_data_for_today, $delivery_data_for_yesterday, $today, $yesterday);

        return $combined_delivery_data;
    }

    /**
     * Take impressions from today's/yesterday's statistics and use them to augment the overall statistics.
     *
     * This step is only necessary because the underlying query builder is incapable of
     * joining a table to itself, which would be necessary to gather today's impressions
     * at the same time as those for the whole period.
     *
     * @param array $period_data
     * @param array $todays_data
     * @param array $yesterdays_data
     * @param dayspan $today
     * @param dayspan $yesterday
     * @return array An array of campaign information including 'todays_impressions' and 'yesterdays_impressions'
     * elements in each, plus hourly breakdowns
     */
    function injectRecentImpressionsIntoCampaignData($period_data, $todays_data, $yesterdays_data, $today, $yesterday)
    {
        $combined_data = array();
        foreach ($period_data as $overall_campaign)
        {
            $campaign_id = $overall_campaign['campaign_id'];

            $campaign_today = $this->_findMatchingCampaignData($campaign_id, $todays_data);
            $todays_impressions = $campaign_today['campaign_impressions'];
            $overall_campaign['todays_impressions'] = $todays_impressions;

            $today_datestr = $today->_startDate->year.'-'.$today->_startDate->month.'-'.$today->_startDate->day;
            $todays_impressions_by_hour = Admin_DA::getHourHistory(array('placement_id' => $campaign_id, 'day_begin' => $today_datestr, 'day_end' => $today_datestr));
            $overall_campaign['todays_impressions_by_hour'] = $todays_impressions_by_hour;

            $campaign_yesterday = $this->_findMatchingCampaignData($campaign_id, $yesterdays_data);
            $yesterdays_impressions = $campaign_yesterday['campaign_impressions'];
            $overall_campaign['yesterdays_impressions'] = $yesterdays_impressions;

            $yesterday_datestr = $yesterday->_startDate->year.'-'.$yesterday->_startDate->month.'-'.$yesterday->_startDate->day;
            $yesterdays_impressions_by_hour = Admin_DA::getHourHistory(array('placement_id' => $campaign_id, 'day_begin' => $yesterday_datestr, 'day_end' => $yesterday_datestr));
            $overall_campaign['yesterdays_impressions_by_hour'] = $yesterdays_impressions_by_hour;

            $combined_data[] = $overall_campaign;
        }
        return $combined_data;
    }

    /**
     * Take impressions from today's statistics and use them to augment the overall statistics.
     *
     * This step is only necessary because the underlying query builder is incapable of
     * joining a table to itself, which would be necessary to gather today's impressions
     * at the same time as those for the whole period.
     *
     * @param array $period_data
     * @param array $todays_data
     * @return array An array of campaign information including 'todays_impressions' element in each
     */
    function injectTodaysImpressionsIntoCampaignData($period_data, $todays_data)
    {
        $combined_data = array();
        foreach ($period_data as $overall_campaign)
        {
            $campaign_id = $overall_campaign['campaign_id'];
            $campaign_today = $this->_findMatchingCampaignData($campaign_id, $todays_data);
            $todays_impressions = $campaign_today['campaign_impressions'];
            $overall_campaign['todays_impressions'] = $todays_impressions;
            $combined_data[] = $overall_campaign;
        }
        return $combined_data;
    }

    /**
     * Find campaign information in an unordered array.
     *
     * @param int $needle The campaign ID to search for
     * @param array $haystack An array of campaign arrays
     * @return array The matching campaign information, otherwise an empty array.
     */
    function _findMatchingCampaignData($needle, $haystack)
    {
        foreach ($haystack as $campaign) {
            if ($campaign['campaign_id'] == $needle) {
                return $campaign;
            }
        }
        return array();
    }

    /**
     * Check if report is allowed to display.
     * Hardcoded to prevent display for Ticketmaster.
     *
     * @return true if allowed to display, false otherwise
     */
    function isAllowedToDisplay()
    {
        // prevent display if Ticketmaster login
        if (phpAds_getUserID() != 31 && parent::isAllowedToDisplay()) {
            return true;
        } else {
            return false;
        }
    }

}
?>
