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

require_once MAX_PATH . '/lib/max/Dal/Admin.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';

/**
 * Controller class for displaying targeting statistics screens.
 *
 * @package    OpenXPlugin
 * @subpackage TargetingStatistics
 * @author     Robert Hunter <roh@m3.net>
 */
class Statistics_TargetingController
{
	var $placement_id;
	var $dal;
	var $_period_start;
	var $_period_end;
	var $base_url_for_day_overview;
	var $base_url_for_zone_detail;

	function useDefaultDataAccessLayer()
	{
		$this->dal =& new MAX_Dal_Admin();
	}

	function useDataAccessLayer(&$data_access_layer)
	{
		$this->dal =& $data_access_layer;
	}

	function summariseIntervalByZone()
	{
		//$zone_list = $this->dal->findZonesInPlacement($this->placement_id);
		$aParams = array('placement_id' => $this->placement_id);
		$zone_list = Admin_DA::getAdZones($aParams);
		$results = array();

		foreach ($zone_list as $zone_id) {
		    $zone_stats = $this->dal->getZoneTargetingStatistics($zone_id, $this->_period_start, $this->_period_end);
		    $results[$zone_id] = $zone_stats;
		}
	    foreach(array_keys($results) as $result_key) {
	    	if (count($results[$result_key]) == 0) {
	    		continue;
	    	}
	    	foreach(array_keys($results[$result_key]) as $zone_id) {
	        	$results[$result_key][$zone_id]['ratio'] = $this->calculateRatio($results[$result_key][$zone_id]);
	        	$results[$result_key][$zone_id]['htmlclass'] = $this->getHtmlClassForIntervalStats($results[$result_key][$zone_id]);
	    	}
	    }
	    return $results;
	}

	function summariseIntervalByAd()
	{
		$ad_list = $this->dal->findAdsInPlacement($this->placement_id);
		foreach ($ad_list as $ad_id) {
			$ad_stats = $this->dal->getAdTargetingStatistics($ad_id, $this->_period_start, $this->_period_end);
			$results[$ad_id] = $ad_stats;
		}
		return $results;
	}

	function setStartDate($oDate)
	{
		$this->_period_start = new Date($oDate);
	}

	function setEndDate($oDate)
	{
		$this->_period_end = $oDate;
	}

	function getStartDateString()
	{
		return $this->formatDate($this->_period_start);
	}

	function getEndDateString()
	{
		return $this->formatDate($this->_period_end);
	}

	function formatDate($date)
	{
        return $date->format('%Y-%m-%d');
	}

	function beginningOfDateWeek($base_date)
	{
		$date_string = Date_Calc::beginOfWeek($base_date->getDay(), $base_date->getMonth(), $base_date->getYear(), '%Y-%m-%d');
		return new Date($date_string);
	}

	function setPeriod($length_code, $base_date_string)
	{
		$base_date = new Date($base_date_string);
		if ($length_code == 'i') {
			$this->_setDatesForSingleInterval($base_date);
		} elseif ($length_code == 'd') {
			$this->_setDatesForSingleDay($base_date);
		} elseif ($length_code == 'daily') {
			$this->_setDatesForSingleDay($base_date);
		} elseif ($length_code == 'm') {
			$this->_setDatesForThisMonth($base_date);
		} elseif ($length_code == 'today') {
			$this->_setDatesForSingleDay($base_date);
		} elseif ($length_code == 'yesterday') {
			$this->_setDatesForYesterday($base_date);
		} elseif ($length_code == 'thisweek') {
			$this->_setDatesForThisWeek($base_date);
		} elseif ($length_code == 'lastweek') {
			$this->_setDatesForLastWeek($base_date);
		} elseif ($length_code == 'thismonth') {
			$this->_setDatesForThisMonth($base_date);
		} elseif ($length_code == 'lastmonth') {
			$this->_setDatesForLastMonth($base_date);
		} else {
			$this->_setDatesForLast7Days($base_date);
		}
	}

	function _setDatesForSingleInterval($base_date)
	{
	    $interval_end = new Date($base_date);
	    $interval_span = new Date_Span('59:59', '%m:%s');
	    $interval_end->addSpan($interval_span);
	    $this->setStartDate($base_date);
	    $this->setEndDate($interval_end);
	}

	function _setDatesForSingleDay($base_date)
	{
		$this->setStartDate($base_date);
		$this->setEndDate($base_date);
	}

	function _setDatesForYesterday($base_date)
	{
		$day_span = new Date_Span('1', '%D');
		$yesterday = new Date($base_date);
		$yesterday->subtractSpan($day_span);

		$this->setStartDate($yesterday);
		$this->setEndDate($yesterday);
	}

	function _setDatesForThisWeek($base_date)
	{
		$day_span = new Date_Span('1', '%D');
		$week_span = new Date_Span('6', '%D');

	    $begin = $this->beginningOfDateWeek($base_date);
		$begin->addSpan($day_span);

		$end = new Date($begin);
		$end->addSpan($week_span);

		$this->setStartDate($begin);
		$this->setEndDate($end);
	}

	function _setDatesForLastWeek($base_date)
	{
		$week_span = new Date_Span('6', '%D');

	    $end = $this->beginningOfDateWeek($base_date);
		$begin = new Date($end);
		$begin->subtractSpan($week_span);

		$this->setStartDate($begin);
		$this->setEndDate($end);
	}

	function _setDatesForLast7Days($base_date)
	{
		$one_week_ago = new Date($base_date);
		$week_span = new Date_Span('6', '%D');
		$one_week_ago->subtractSpan($week_span);
		$this->setStartDate($one_week_ago);
		$this->setEndDate($base_date);
	}

	function _setDatesForThisMonth($base_date)
	{
		$first_of_this_month = new Date($base_date);
		$first_of_this_month->setDay(1);

		$days_in_month = $first_of_this_month->getDaysInMonth();
		$end_of_this_month = new Date($first_of_this_month);
		$end_of_this_month->setDay($days_in_month);

		$this->setStartDate($first_of_this_month);
		$this->setEndDate($end_of_this_month);
	}

	function _setDatesForLastMonth($base_date)
	{
		$end_of_last_month_string = Date_Calc::endOfPrevMonth(1, $base_date->getMonth(), $base_date->getYear(), '%Y-%m-%d');
		$end_of_last_month = new Date($end_of_last_month_string);

		$first_of_last_month = new Date($end_of_last_month);
		$first_of_last_month->setDay(1);

		$this->setStartDate($first_of_last_month);
		$this->setEndDate($end_of_last_month);
	}

	function getPeriodLength()
	{
		return $this->_period_end->getJulianDate() - $this->_period_start->getJulianDate();
	}

	function summarisePlacement()
	{
		$dal = & $this->dal;
		$results = $dal->getPlacementOverviewTargetingStatistics($this->placement_id, $this->_period_start, $this->_period_end);
		foreach (array_keys($results) as $key) {
			$date_url_part = $this->convertDateStringToNavigationFormat($results[$key]['day']);
		    $results[$key]['link'] = $this->base_url_for_day_overview . '&day='. $date_url_part;
	    	$results[$key]['ratio'] = $this->calculateRatio($results[$key]);
	    	$results[$key]['htmlclass'] = $this->getHtmlClassForIntervalStats($results[$key]);
	    	$results[$key]['has_data'] = true;
		}
		$padded_results = $this->padEmptyDays($results);
		return array_values($padded_results);
	}

	function padEmptyDays($sparse_days)
	{
		$dense = array();
		$current_date = new Date($this->_period_start);
		$day_span = new Date_Span('1', '%D');
		$number_of_days = $this->getPeriodLength();

		foreach($sparse_days as $day_data) {
			$day = $day_data['day'];
			$key = $this->fullyQualifyDateString($day);
			$dense[$key] = $day_data;
		}

	    for ($i = 0; $i <= $number_of_days; $i++) {
	    	$key = $current_date->format('%Y-%m-%d');
	    	$current_date->addSpan($day_span);
	    	if (array_key_exists($key, $dense)) {
	    		continue;
	    	}
	    	$empty_data = array('day' => $key, 'has_data' => false, 'impressions_requested' => null, 'actual_impressions' => null);
		    $dense[$key] = $empty_data;

		}
		krsort($dense);

		return $dense;
	}

	function fullyQualifyDateString($short_date)
	{
		if (strlen($short_date) == 8) {
			return '20' . $short_date;
		}
	    return $short_date;
	}

	function convertDateStringToNavigationFormat($datestring)
	{
        $date = new Date($datestring);
        return $date->format('%Y%m%d');
	}

	function getHtmlClassForIntervalStats($stats)
	{
		$percentage = $stats['ratio'];
		if (($percentage < 75) || ($percentage > 125)) {
		    $quantifier = 'ratio-very-off-target';
		} elseif (($percentage < 90) || ($percentage > 110)) {
		    $quantifier = 'ratio-somewhat-off-target';
		}
		if ($percentage < 90) {
			return 'ratio-under-target ' . $quantifier;
		}
		if ($percentage > 110) {
			return 'ratio-over-target ' . $quantifier;
		}
		return 'ratio-met-target';
	}

	function calculateRatio($statistics)
	{
		$actual = $statistics['actual_impressions'];
	    $target = $statistics['impressions_requested'];

		if (!$target) {
			return false;
		}
		$ratio = $actual / $target;
		$ratio_string = round($ratio * 100);
		return $ratio_string;
	}

	function summarisePlacementDay()
	{
		$results = $this->dal->getPlacementDailyTargetingStatistics($this->placement_id, $this->_period_start);

		foreach (array_keys($results) as $key) {
			$interval = $results[$key]['interval_start']->format('%Y-%m-%d %H:%M:%S');
		    $results[$key]['link'] = $this->base_url_for_zone_detail . '&date=' . urlencode($interval);
		    $results[$key]['ratio'] = $this->calculateRatio($results[$key]);
		    $results[$key]['htmlclass'] = $this->getHtmlClassForIntervalStats($results[$key]);
		    $results[$key]['has_data'] = true;
		}

		return $this->padEmptyHours($results);
	}

	function padEmptyHours($stats)
	{
		$result = array();

		foreach($stats as $stat) {
			$hour = (int) $stat['interval_start']->getHour();
		    $result[$hour] = $stat;
        }

		for ($hour_number = 0; $hour_number < 24; $hour_number++) {
			if ($result[$hour_number]['has_data']) {
			    continue;
			}
			$hour_start = $this->startOfHour($hour_number, $this->_period_start);
			$hour_end = $this->endOfHour($hour_number, $this->_period_start);

		    $result[$hour_number] = array(
                'interval_start' => $hour_start,
                'interval_end' => $hour_end,
                'has_data' => false
            );
		}

		ksort($result);

	    return $result;
	}

	function startOfHour($hour_number, $date)
	{
		$hour_start = new Date($date);
		$hour_start->setHour($hour_number);
		$hour_start->setMinute(0);
		$hour_start->setSecond(0);

		return $hour_start;
	}

	function endOfHour($hour_number, $date)
	{
		$hour_end = new Date($date);
		$hour_end->setHour($hour_number);
		$hour_end->setMinute(59);
		$hour_end->setSecond(59);

		return $hour_end;
	}

	function roundDecimals($float, $decimal_places = 0)
	{
		return round($float, $decimal_places);
	}
}

?>
