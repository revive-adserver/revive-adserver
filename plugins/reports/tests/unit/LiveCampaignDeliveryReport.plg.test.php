<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * Report tests for Max Media Manager
 *
 * @since 0.3.22 - Mar 27, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id$
 */

require_once MAX_PATH . '/plugins/reports/standard/liveCampaignDeliveryReport.plugin.php';

class LiveCampaignDeliveryReportTest extends UnitTestCase
{
    function testCalculateTodaysMisdelivery_WholeDay_Perfect()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 12,
            'campaign_priority' => 1,
            'campaign_booked_views' => 700,
            'todays_impressions' => 50
        );
        $misdelivery = $report->calculateTodaysMisdelivery($campaign);
        $this->assertEqual($misdelivery, 0, 'Half a day at 100 impressions per day, 50 should be right on target. %s');
    }

    function testCalculateTodaysMisdelivery_NoInformation()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 12,
            'campaign_priority' => 1,
            'campaign_booked_views' => 700,
        );
        $misdelivery = $report->calculateTodaysMisdelivery($campaign);
        $this->assertEqual($misdelivery, false, "No impressions for today, so we can't calculate misdelivery. %s");
    }

    function testCalculateMisdelivery_WholeDay_Perfect()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 0,
            'campaign_priority' => 1,
            'campaign_booked_views' => 700,
            'campaign_impressions' => 200,
        );
        $misdelivery = $report->calculateOverallMisdelivery($campaign);
        $this->assertEqual($misdelivery, 0, '100 impressions per day should be right on target. %s');
    }

    function testCalculateMisdelivery_WholeDay_Overdelivered()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 0,
            'campaign_priority' => 1,
            'campaign_booked_views' => 700,
            'campaign_impressions' => 400,
        );
        $misdelivery = $report->calculateOverallMisdelivery($campaign);
        $this->assertEqual($misdelivery, 1, '200 impressions per day is twice as much as needed %s');
    }

    function testCalculateMisdelivery_PartDay_Perfect()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 12,
            'campaign_priority' => 1,
            'campaign_booked_views' => 700,
            'campaign_impressions' => 250,
        );
        $misdelivery = $report->calculateOverallMisdelivery($campaign);
        $this->assertEqual($misdelivery, 0, '100 impressions per day and one half-day should be spot on. %s');
    }

    function testCalculateMisdelivery_Premature_Zero()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '1999-12-01',
            'stats_most_recent_hour' => 12,
            'campaign_priority' => 1,
            'campaign_booked_views' => 700,
            'campaign_impressions' => 0,
        );
        $misdelivery = $report->calculateOverallMisdelivery($campaign);
        $this->assertEqual($misdelivery, 0, 'A campaign only needs to deliver during its lifetime, not before. %s');
    }

    function testCaclulateMisdelivery_Exclusive()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 12,
            'campaign_priority' => -1,
            'campaign_booked_views' => -1,
            'campaign_impressions' => 9000,
        );
        $misdelivery = $report->calculateOverallMisdelivery($campaign);
        $this->assertEqual($misdelivery, 0, 'An exclusive campaign cannot misdeliver because it has no target. %s');
    }

    function testCaclulateMisdelivery_LowPriority()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaign = array(
            'campaign_start' => '2001-01-01',
            'campaign_end' => '2001-01-07',
            'stats_most_recent_day' => '2001-01-03',
            'stats_most_recent_hour' => 12,
            'campaign_priority' => 0,
            'campaign_booked_views' => -1,
            'campaign_impressions' => 9000,
        );
        $misdelivery = $report->calculateOverallMisdelivery($campaign);
        $this->assertEqual($misdelivery, 0, 'An low-priority campaign cannot misdeliver because it has no target. %s');
    }

    function testInjectingTodaysDeliveryDataWorks()
    {
        $report = new Plugins_Reports_Standard_LiveCampaignDeliveryReport();
        $campaigns_overall = array(
            array('campaign_id' => 36, 'identifying_text' => 'woof'),
        );
        $campaigns_today = array(
            array('campaign_id' => 52, 'campaign_impressions' => 600),
            array('campaign_id' => 36, 'campaign_impressions' => 300),
        );

        $combined_campaigns = $report->injectTodaysImpressionsIntoCampaignData($campaigns_overall, $campaigns_today);
        $campaign = $combined_campaigns[0];
        $this->assertEqual($campaign['todays_impressions'], 300);
    }
}

?>
