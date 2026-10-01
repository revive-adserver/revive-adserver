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

require_once MAX_PATH . '/plugins_repo/openXVideoAds/www/admin/plugins/videoReport/stats-api.php';

class Test_OX_Video_Report_WeekLabels extends UnitTestCase
{
    public function testWeekLabelsUseTheSameIsoWeekAndYearAsTheQuery()
    {
        $report = new class extends OX_Video_Report {
            public function __construct() {}

            public function getWeekLabels($startDate, $endDate)
            {
                return $this->getDateLabelsBetweenDates($startDate, $endDate, 'week');
            }
        };

        $this->assertEqual(['Week 53 (2020)'], $report->getWeekLabels('2021-01-01', '2021-01-01'));
        $this->assertEqual(
            ['Week 53 (2020)', 'Week 53 (2020)', 'Week 53 (2020)'],
            $report->getWeekLabels('2020-12-31', '2021-01-02'),
        );
        $this->assertEqual(['Week 01 (2021)'], $report->getWeekLabels('2021-01-04', '2021-01-04'));
    }
}
