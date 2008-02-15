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

require_once MAX_PATH . '/plugins/statistics/targeting/TargetingController.php';
require_once MAX_PATH . '/lib/max/Dal/Admin.php';

Mock::generate('MAX_Dal_Admin');

class TargetingController_EmptyFixture_Test extends UnitTestCase
{
	var $example_overview_data;
	var $example_daily_data;

	function setupExampleData()
	{
		$this->example_overview_data = array(
			array('day' => '01-01-01', 'impressions_requested' => 200, 'actual_impressions' => 210),
			array('day' => '01-01-02', 'impressions_requested' => 200, 'actual_impressions' => 200),
			array('day' => '01-01-03', 'impressions_requested' => 300, 'actual_impressions' => 290)
		);

		$this->example_daily_data = array(
	    	array('interval_start' => new Date('2001-10-20 00:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 01:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 02:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 03:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 04:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 05:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 06:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 07:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 08:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 09:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 10:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 11:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 12:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 13:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 14:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 15:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 16:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50),
	    	array('interval_start' => new Date('2001-10-20 17:00:00'), 'impressions_requested' => 50, 'actual_impressions' => 50)
    	);
	}
	function testInstantiation()
	{
		$controller = new Statistics_TargetingController();
		$this->assertNoErrors('Clients should be able to instantiate a TargetingController with no parameters. %s');
	}

	function testControllerUsesDALayer()
	{
		$dal =& new MockMAX_Dal_Admin($this);

		$dal->expectOnce('getPlacementOverviewTargetingStatistics');
        $dal->setReturnValue('getPlacementOverviewTargetingStatistics', array());
		$controller = new Statistics_TargetingController();
		$controller->useDataAccessLayer($dal);

		$monday = new Date('2001-01-01');
    	$friday = new Date('2001-01-05');

        $controller->placement_id = 50;
        $controller->setStartDate($monday);
        $controller->setEndDate($friday);

		$overview = $controller->summarisePlacement();
		$dal->tally();
	}

	function testSetPeriodMonthly()
	{
	    $controller = new Statistics_TargetingController();
	    $base_date = new Date('1987-06-05');
	    $controller->setPeriod('m', $base_date);
	    $start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '1987-06-01');
	    $this->assertEqual($end_date, '1987-06-30');
	}

	function testSetPeriodWeekly()
	{
	    $controller = new Statistics_TargetingController();
	    $base_date = new Date('1987-06-05 01:23:45');
	    $controller->setPeriod('w', $base_date);
	    $start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '1987-05-30');
	    $this->assertEqual($end_date, '1987-06-05');
	}

	function testSetPeriodDaily()
	{
        $controller = new Statistics_TargetingController();
	    $base_date = new Date('1987-06-05 01:23:45');
	    $controller->setPeriod('daily', $base_date);
	    $start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '1987-06-05');
	    $this->assertEqual($end_date, '1987-06-05');
	}

	function testSetPeriodDay()
	{
        $controller = new Statistics_TargetingController();
	    $base_date = new Date('1987-06-05 01:23:45');
	    $controller->setPeriod('d', $base_date);
	    $start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '1987-06-05');
	    $this->assertEqual($end_date, '1987-06-05');
	}

	function testSetPeriodToday()
	{
        $controller = new Statistics_TargetingController();
	    $base_date = new Date('1987-06-05');
	    $controller->setPeriod('today', $base_date);
	    $start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '1987-06-05');
	    $this->assertEqual($end_date, '1987-06-05');
	}

	function testSetPeriodYesterday()
	{
        $controller = new Statistics_TargetingController();
	    $base_date = new Date('1987-06-05');
	    $controller->setPeriod('yesterday', $base_date);
	    $start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '1987-06-04');
	    $this->assertEqual($end_date, '1987-06-04');
	}

	function testSetPeriodThisWeek()
	{
		$controller = new Statistics_TargetingController();
		$base_date = new Date('2003-01-23');
		$controller->setPeriod('thisweek', $base_date);
		$start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '2003-01-20');
	    $this->assertEqual($end_date, '2003-01-26');
	}

	function testSetPeriodLastWeek()
	{
		$controller = new Statistics_TargetingController();
		$base_date = new Date('2003-01-23');
		$controller->setPeriod('lastweek', $base_date);
		$start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '2003-01-13');
	    $this->assertEqual($end_date, '2003-01-19');
	}

	function testSetPeriodLast7Days()
	{
		$controller = new Statistics_TargetingController();
		$base_date = new Date('2003-01-23');
		$controller->setPeriod('last7days', $base_date);
		$start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '2003-01-17');
	    $this->assertEqual($end_date, '2003-01-23');
	}

	function testSetPeriodThisMonth()
	{
		$controller = new Statistics_TargetingController();
		$base_date = new Date('2003-01-23');
		$controller->setPeriod('thismonth', $base_date);
		$start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '2003-01-01');
	    $this->assertEqual($end_date, '2003-01-31');
	}

	function testSetPeriodLastMonth()
	{
		$controller = new Statistics_TargetingController();
		$base_date = new Date('2003-01-23');
		$controller->setPeriod('lastmonth', $base_date);
		$start_date = $controller->getStartDateString();
	    $end_date = $controller->getEndDateString();
	    $this->assertEqual($start_date, '2002-12-01');
	    $this->assertEqual($end_date, '2002-12-31');
	}

	function testPadEmptyHoursMarksEmpties()
	{
		$unpadded_stats = array(
		    array('interval_start' => new Date('2000-01-01 08:00:00'), 'has_data'=>true)
		);
	    $controller = new Statistics_TargetingController();
	    $padded = $controller->padEmptyHours($unpadded_stats);
	    $this->assertFalse($padded[7]['has_data']);
	    $this->assertTrue($padded[8]['has_data']);
	    $this->assertFalse($padded[9]['has_data']);
	}

	function testPadEmptyHoursHasStartAndEnd()
	{
		$unpadded_stats = array(
		    array('interval_start' => new Date('2000-01-01 08:00:00'), 'has_data'=>true)
		);
	    $controller = new Statistics_TargetingController();
	    $padded = $controller->padEmptyHours($unpadded_stats);
	    $this->assertEqual($padded[7]['interval_start']->getHour(), 7, 'Hours for the start time of an hour should be match their index. %s');
	    $this->assertEqual($padded[7]['interval_start']->getMinute(), 0, 'Minutes for the start time of an hour should be 0. %s');
	    $this->assertEqual($padded[7]['interval_start']->getSecond(), 0, 'Seconds for the start time of an hour should be 0. %s');
	    $this->assertEqual($padded[7]['interval_end']->getHour(), 7, 'Hours for the end time of an hour should be match their index. %s');
	    $this->assertEqual($padded[7]['interval_end']->getMinute(), 59, 'Minutes for the end time of an hour should be 59. %s');
	    $this->assertEqual($padded[7]['interval_end']->getSecond(), 59, 'Seconds for the end time of an hour should be 59. %s');
	}

	function testRoundDecimals()
	{
		$controller =& new Statistics_TargetingController();

		$rounded = $controller->roundDecimals(6.33333321);
		$this->assertEqual($rounded, 6);

		$rounded_2dp = $controller->roundDecimals(501.3579, 2);
		$this->assertEqual($rounded_2dp, 501.36);
	}

	function setupBasicControllerParameters()
    {
    	$monday = new Date('2001-01-01');
    	$friday = new Date('2001-01-05');

        $this->controller->placement_id = 50;
        $this->controller->setStartDate($monday);
        $this->controller->setEndDate($friday);
    }
}

class TargetingController_Report_Test extends TargetingController_EmptyFixture_Test
{
	var $controller;
	var $dal;

	function setUp()
	{
	    $this->dal =& new MockMAX_Dal_Admin($this);
        $this->controller =& new Statistics_TargetingController();
        $this->controller->useDataAccessLayer($this->dal);
        $this->setupExampleData();
        $this->setupBasicControllerParameters();
	}

}

class TargetingController_PlacementOverview_Test extends TargetingController_Report_Test
{
    function testPlacementUse()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', $this->example_overview_data);
        $days = $this->controller->summarisePlacement();
        $this->assertEqual(count($days), 5, 'All five days should show. %s');
    }

    function testPlacementHasKeys()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', $this->example_overview_data);
        $days = $this->controller->summarisePlacement();
        $this->assertTrue(key_exists('day', $days[0]));
        $this->assertTrue(key_exists('impressions_requested', $days[0]));
        $this->assertTrue(key_exists('actual_impressions', $days[0]));
    }

    function testPlacementShowsReverseChronologicalOrder()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', $this->example_overview_data);
        $days = $this->controller->summarisePlacement();
        reset($days);
        $first_day = current($days);
        next($days);
        $second_day = current($days);
        $this->assertEqual($first_day['day'], '2001-01-05', 'The most recent date should be first. %s');
        $this->assertEqual($second_day['day'], '2001-01-04', 'The second-most recent date should be second. %s');
    }

    function testEmptyDaysAreBlank()
    {
    	$sparse_days = array(
			array('day' => '2001-01-05', 'impressions_requested' => 200, 'actual_impressions' => 210),
			array('day' => '2001-01-07', 'impressions_requested' => 300, 'actual_impressions' => 290)
		);

        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', $sparse_days);

		$this->controller->setPeriod('w', '2001-01-07');
        $days = $this->controller->summarisePlacement();
        reset($days);
        $first_day = current($days);
        next($days);
        $second_day = current($days);
        next($days);
        $third_day = current($days);

        $this->assertTrue($first_day['has_data'], 'The first day should be marked as having data.');
        $this->assertFalse($second_day['has_data'], 'The second day had no data so should be marked as such.');
        $this->assertTrue($third_day['has_data'], 'The third day should be marked as having data.');
    }

    function testLinksToDetail()
    {
    	$this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-02-03')));
        $this->controller->base_url_for_day_overview = 'http://example.com/day.php?param1=value&param2=value';
        $days = $this->controller->summarisePlacement();
        $this->assertEqual($days[0]['link'], 'http://example.com/day.php?param1=value&param2=value&day=20010203');
    }

    function testRatio()
    {
    	$this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-01-05', 'impressions_requested' => 140, 'actual_impressions' => 70)));
    	$days = $this->controller->summarisePlacement();
    	$day_information = $days[0];
    	$this->assertEqual($day_information['ratio'], '50');
    }

    function testRatioClass_Met()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-01-05', 'day' => '2001-01-05', 'impressions_requested' => 600, 'actual_impressions' => 600)));
        $days = $this->controller->summarisePlacement();
        $this->assertEqual($days[0]['htmlclass'], 'ratio-met-target');
    }

    function testRatioClass_Missed_Heaps()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-01-05', 'impressions_requested' => 600, 'actual_impressions' => 300)));
        $days = $this->controller->summarisePlacement();
        $this->assertEqual($days[0]['htmlclass'], 'ratio-under-target ratio-very-off-target');
    }

    function testRatioClass_Missed_Some()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-01-05', 'impressions_requested' => 600, 'actual_impressions' => 500)));
        $days = $this->controller->summarisePlacement();
        $this->assertEqual($days[0]['htmlclass'], 'ratio-under-target ratio-somewhat-off-target');
    }

    function testRatioClass_Exceeded_Heaps()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-01-05', 'impressions_requested' => 600, 'actual_impressions' => 1200)));
        $days = $this->controller->summarisePlacement();
        $this->assertEqual($days[0]['htmlclass'], 'ratio-over-target ratio-very-off-target');
    }

    function testRatioClass_Exceeded_Some()
    {
        $this->dal->setReturnValue('getPlacementOverviewTargetingStatistics', array(array('day' => '2001-01-05', 'impressions_requested' => 600, 'actual_impressions' => 700)));
        $days = $this->controller->summarisePlacement();
        $this->assertEqual($days[0]['htmlclass'], 'ratio-over-target ratio-somewhat-off-target');
    }
}

class TargetingController_PlacementDailyOverview_Test extends TargetingController_Report_Test
{
    function testPlacementDayUse()
    {
    	$saturday = new Date('2001-10-20 00:17:00');

    	$dal =& new MockMAX_Dal_Admin($this);
    	$this->controller =& new Statistics_TargetingController();
        $this->controller->useDataAccessLayer($dal);

        $dal->setReturnValue('getPlacementDailyTargetingStatistics', $this->example_daily_data);
        $dal->expectOnce('getPlacementDailyTargetingStatistics');
        $intervals = $this->controller->summarisePlacementDay();

        $this->assertEqual(count($intervals), 24);

        $first_hour = $intervals[0];
        $this->assertEqual($first_hour['interval_start'], new Date('2001-10-20 00:00:00'));

        $dal->tally();
    }

    function testEmptyHoursAreBlank()
    {
        $five_oclock = new Date('2003-06-02 05:00:00');
        $this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => $five_oclock)));
        $day_stats = $this->controller->summarisePlacementDay();
        $this->assertFalse($day_stats[0]['has_data']);
        $this->assertTrue($day_stats[5]['has_data']);
    }

    function testResultsAreInOrder()
    {
    	$five_oclock = new Date('2003-06-02 05:00:00');
    	$this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => $five_oclock)));
    	$day_stats = $this->controller->summarisePlacementDay();
    	$first_hour = current($day_stats);
    	$second_hour = next($day_stats);
    	$third_hour = next($day_stats);
    	$this->assertEqual($first_hour, $day_stats[0]);
    	$this->assertEqual($second_hour, $day_stats[1]);
    	$this->assertEqual($third_hour, $day_stats[2]);
    }

    function testLinksToDetail()
    {
    	$this->controller->base_url_for_zone_detail = 'http://example.com/zone.php?q1=1';
    	$this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => new Date('1987-12-31 11:00:00'))));
    	$day_stats = $this->controller->summarisePlacementDay();
    	$this->assertEqual($day_stats[11]['link'], 'http://example.com/zone.php?q1=1&date=1987-12-31+11%3A00%3A00');
    }

    function testRatio()
    {
    	$this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => new Date('1999-10-15 15:00:00'), 'impressions_requested' => 140, 'actual_impressions' => 70)));
    	$day_stats = $this->controller->summarisePlacementDay();
    	$this->assertEqual($day_stats[15]['ratio'], '50%');
    }

    function testRatioClass_Met()
    {
        $this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => new Date('1999-10-15 15:00:00'), 'impressions_requested' => 140, 'actual_impressions' => 140)));
        $day_stats = $this->controller->summarisePlacementDay();
        $this->assertEqual($day_stats[15]['htmlclass'], 'ratio-met-target');
    }

    function testRatioClass_Missed()
    {
        $this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => new Date('1999-10-15 15:00:00'), 'impressions_requested' => 600, 'actual_impressions' => 300)));
        $day_stats = $this->controller->summarisePlacementDay();
        $this->assertEqual($day_stats[15]['htmlclass'], 'ratio-under-target ratio-very-off-target');
    }

    function testRatioClass_Exceeded()
    {
        $this->dal->setReturnValue('getPlacementDailyTargetingStatistics', array(array('interval_start' => new Date('1999-10-15 15:00:00'), 'impressions_requested' => 600, 'actual_impressions' => 1200)));
        $day_stats = $this->controller->summarisePlacementDay();
        $this->assertEqual($day_stats[15]['htmlclass'], 'ratio-over-target ratio-very-off-target');
    }
}

class TargetingController_SummariseIntervalByZone_Test extends TargetingController_Report_Test
{
	function testZoneSummaryUse()
	{
		$lunchtime = new Date('2003-04-05 13:00:00');
		$lunch_start = new Date('2003-04-05 13:00:00');
		$lunch_end = new Date('2003-04-05 13:59:59');

		$zone50_data = array(
			array('zone_id' => 50, 'ad_id' => 300, 'impressions_requested' => 1000, 'actual_impressions' => 889, 'interval_start' => $lunchtime),
			array('zone_id' => 50, 'ad_id' => 310, 'impressions_requested' =>  600, 'actual_impressions' => 989, 'interval_start' => $lunchtime),
			array('zone_id' => 50, 'ad_id' => 320, 'impressions_requested' => 7000, 'actual_impressions' => 9009, 'interval_start' => $lunchtime),
		);
		$zone51_data = array(
			array('zone_id' => 51, 'ad_id' => 300, 'impressions_requested' => 1500, 'actual_impressions' => 880, 'interval_start' => $lunchtime)
		);

		$this->dal->setReturnValue('getZoneTargetingStatistics', $zone50_data, array(50, $lunch_start, $lunch_end));
		$this->dal->setReturnValue('getZoneTargetingStatistics', $zone51_data, array(51, $lunch_start, $lunch_end));
		$this->dal->setReturnValue('findZonesInPlacement', array(50, 51));

		/**
		 * @TODO Fix broken tests below!
		 */
		//$this->dal->expectCallCount('getZoneTargetingStatistics', 2);
        //$this->dal->expectArgumentsAt(0, 'getZoneTargetingStatistics', array(50, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
		//$this->dal->expectArgumentsAt(1, 'getZoneTargetingStatistics', array(51, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));

		//$this->controller->setPeriod('i', $lunchtime);
        //$this->controller->useDataAccessLayer(&$this->dal);
		//$results = $this->controller->summariseIntervalByZone();

		//$this->dal->tally();
	}

	function testZoneSummaryUsesData()
	{
		$lunchtime = new Date('2003-04-05 13:00:00');
		$lunch_start = new Date('2003-04-05 13:00:00');
		$lunch_end = new Date('2003-04-05 13:59:59');

		$zone50_data = array(
			array('zone_id' => 50, 'ad_id' => 300, 'impressions_requested' => 1000, 'actual_impressions' => 889, 'interval_start' => $lunchtime),
			array('zone_id' => 50, 'ad_id' => 310, 'impressions_requested' =>  600, 'actual_impressions' => 989, 'interval_start' => $lunchtime),
			array('zone_id' => 50, 'ad_id' => 320, 'impressions_requested' => 7000, 'actual_impressions' => 9009, 'interval_start' => $lunchtime),
		);
		$zone51_data = array(
			array('zone_id' => 51, 'ad_id' => 300, 'impressions_requested' => 1500, 'actual_impressions' => 880, 'interval_start' => $lunchtime)
		);

		/**
		 * @TODO Fix broken tests below!
		 */
		//$this->dal->setReturnValue('getZoneTargetingStatistics', $zone50_data, array(50, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
		//$this->dal->setReturnValue('getZoneTargetingStatistics', $zone51_data, array(51, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
		//$this->dal->setReturnValue('findZonesInPlacement', array(50, 51));
		//$this->controller->setPeriod('i', $lunchtime);
		//$results = $this->controller->summariseIntervalByZone();
		//$this->assertEqual(count($results), 2);
		//$returned_zone50 = $results[50];
		//$this->assertEqual($returned_zone50[0]['impressions_requested'], 1000);
	}

	function testZoneInformationIsStructured()
	{
		$lunchtime = new Date('2003-04-05 13:00:00');
		$lunch_start = new Date('2003-04-05 13:00:00');
		$lunch_end = new Date('2003-04-05 13:59:59');

		$zone50_data = array(
			array('zone_id' => 50, 'ad_id' => 300, 'impressions_requested' => 1000, 'actual_impressions' => 889, 'interval_start' => $lunchtime),
			array('zone_id' => 50, 'ad_id' => 310, 'impressions_requested' =>  600, 'actual_impressions' => 989, 'interval_start' => $lunchtime),
			array('zone_id' => 50, 'ad_id' => 320, 'impressions_requested' => 7000, 'actual_impressions' => 9009, 'interval_start' => $lunchtime),
		);
		$zone51_data = array(
			array('zone_id' => 51, 'ad_id' => 300, 'impressions_requested' => 1500, 'actual_impressions' => 880, 'interval_start' => $lunchtime)
		);

		/**
		 * @TODO Fix broken tests below!
		 */
		//$this->dal->setReturnValue('getZoneTargetingStatistics', $zone50_data, array(50, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
		//$this->dal->setReturnValue('getZoneTargetingStatistics', $zone51_data, array(51, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
		//$this->dal->setReturnValue('findZonesInPlacement', array(50, 51));
		//$this->controller->setPeriod('i', $lunchtime);
		//$zonesummary = $this->controller->summariseIntervalByZone();
		//$this->assertIsA($zonesummary, 'array');
		//$this->assertIsA($zonesummary[50], 'array');
		//$this->assertEqual($zonesummary[50][0]['zone_id'], 50);
	}

	function testRatio()
    {
		/**
		 * @TODO Fix broken tests below!
		 */
    	//$this->dal->setReturnValue('getZoneTargetingStatistics', array(array('zone_id' => 50, 'ad_id' => 300, 'impressions_requested' => 120, 'actual_impressions' => 90)));
    	//$this->dal->setReturnValue('findZonesInPlacement', array(50));
    	//$zone_stats = $this->controller->summariseIntervalByZone();
    	//$this->assertEqual($zone_stats[50][0]['ratio'], 75);
    }
}

class TargetingController_SummariseIntervalByAd_Test extends TargetingController_Report_Test
{
	function testAdSummaryUse()
	{
		$lunchtime = new Date('2003-04-05 13:00:00');
		$lunch_start = new Date('2003-04-05 13:00:00');
		$lunch_end = new Date('2003-04-05 13:59:59');

		$this->setupStuff();
		$this->dal->expectCallCount('getAdTargetingStatistics', 2);
        $this->dal->expectArgumentsAt(0, 'getAdTargetingStatistics', array(300, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
		$this->dal->expectArgumentsAt(1, 'getAdTargetingStatistics', array(310, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));

		$this->controller->setPeriod('i', $lunchtime);
        $this->controller->useDataAccessLayer($this->dal);
		$results = $this->controller->summariseIntervalByAd();

		$this->dal->tally();
	}

	function setupStuff()
	{
		$lunchtime = new Date('2003-04-05 13:00:00');
		$lunch_start = new Date('2003-04-05 13:00:00');
		$lunch_end = new Date('2003-04-05 13:59:59');

		$ad300_data = array(
			array('ad_id' => 300, 'zone_id' => 50, 'impressions_requested' => 1000, 'actual_impressions' => 889, 'interval_start' => $lunchtime),
			array('ad_id' => 300, 'zone_id' => 51, 'impressions_requested' =>  600, 'actual_impressions' => 989, 'interval_start' => $lunchtime),
			array('ad_id' => 300, 'zone_id' => 52, 'impressions_requested' => 7000, 'actual_impressions' => 9009, 'interval_start' => $lunchtime),
		);
		$ad310_data = array(
			array('ad_id' => 310, 'zone_id' => 50, 'impressions_requested' => 1500, 'actual_impressions' => 880, 'interval_start' => $lunchtime)
		);

		$this->dal->setReturnValue('getAdTargetingStatistics', $ad300_data, array(300, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
        $this->dal->setReturnValue('getAdTargetingStatistics', $ad310_data, array(310, new EqualExpectation($lunch_start), new EqualExpectation($lunch_end)));
        $this->dal->setReturnValue('findAdsInPlacement', array(300, 310));

        $this->controller->setPeriod('i', $lunchtime);
	}

	function testAdSummaryUsesData()
	{
        $this->setupStuff();
        $results = $this->controller->summariseIntervalByAd();

        $this->assertEqual(count($results), 2);
        $returned_ad300 = $results[300];
        $this->assertEqual($returned_ad300[0]['impressions_requested'], 1000);
	}

	function testAdInformationIsStructured()
	{
		$this->setupStuff();
        $adsummary = $this->controller->summariseIntervalByAd();
        $this->assertIsA($adsummary, 'array');
        $this->assertIsA($adsummary[300], 'array');
        $this->assertEqual($adsummary[300][0]['ad_id'], 300);
	}
}

?>
