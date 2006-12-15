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
$Id: ReportExecuteModule.admin.test.php 5637 2006-10-09 19:38:18Z scott@m3.net $
*/

require_once MAX_PATH . '/lib/max/Admin/Reporting/ExecuteModule.php';
require_once MAX_PATH . '/plugins/reports/Reports.php';

class ReportExecuteTest extends UnitTestCase
{
    function testSimpleInfo()
    {
        $import = array(
                'example' => array(
                    'title' => 'Simple text',
                    'type' => 'edit',
                ),
            );
        $info = array('plugin-import' => $import);
        $passed_in = array('example' => 'simple_value');
        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $this->assertEqual($variables[0], "simple_value");
    }

    function testSimpleInfo_Missing()
    {
        $import = array(
                'example' => array(
                    'title' => 'Empty text',
                    'type' => 'edit',
                ),
            );
        $info = array('plugin-import' => $import);
        $passed_in = array(); //no values
        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $this->assertEqual($variables[0], '');
    }

    function testDaySpan_MissingPreset()
    {
        $import = array(
                'example' => array(
                    'title' => 'Date Range',
                    'type' => 'day-span',
                ),
            );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_start' => '1998-07-06',
            'example_end' => '1998-08-08'
        );
        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDateForDisplay(), '06/07/1998');
        $this->assertEqual($oDaySpan->getEndDateForDisplay(), '08/08/1998');
    }

    function testDaySpan_Specific()
    {
        $import = array(
                'example' => array(
                    'title' => 'Date range',
                    'type' => 'day-span',
                ),
            );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'specific',
            'example_start' => '1998-07-06',
            'example_end' => '1998-08-08'
        );
        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDateForDisplay(), '06/07/1998');
        $this->assertEqual($oDaySpan->getEndDateForDisplay(), '08/08/1998');
    }

    function testDaySpan_ThisWeek()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'thisweek',
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDate(), new Date('2000-06-11 00:00:00'));
        $this->assertEqual($oDaySpan->getEndDate(), new Date('2000-06-18 00:00:00'));
    }

    function testDaySpan_LastWeek()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'lastweek',
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDate(), new Date('2000-06-04 00:00:00'));
        $this->assertEqual($oDaySpan->getEndDate(), new Date('2000-06-11 00:00:00'));
    }

    function testDaySpan_Last7Days()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'last7days',
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDate(), new Date('2000-06-09 00:00:00'));
        $this->assertEqual($oDaySpan->getEndDate(), new Date('2000-06-16 00:00:00'));
    }

    function testDaySpan_LastMonth()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'lastmonth',
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDate(), new Date('2000-05-01 00:00:00'));
        $this->assertEqual($oDaySpan->getEndDate(), new Date('2000-06-01 00:00:00'));
    }

    function testDaySpan_ThisMonth()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'thismonth',
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertEqual(count($variables), 1);
        $oDaySpan = $variables[0];
        $this->assertIsA($oDaySpan, 'DaySpan');
        $this->assertEqual($oDaySpan->getStartDate(), new Date('2000-06-01 00:00:00'));
        $this->assertEqual($oDaySpan->getEndDate(), new Date('2000-07-01 00:00:00'));
    }

    function testDaySpan_MissingEverything()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            // nothing passed in
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertError();
    }

    function testDaySpan_FunnyPreset()
    {
        $import = array(
            'example' => array(
                'title' => 'Date range',
                'type' => 'day-span',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_preset' => 'This_Is_Not_A_Real_Specifier'
        );

        $module = new ReportExecuteModule();
        $module->now = new Date('2000-06-16 16:16:16');
        $variables = $module->_getVariablesForReport($info, $passed_in);
        $this->assertError();
    }

    function testEntity_All()
    {
        $import = array(
            'example' => array(
                'title' => 'Report on',
                'type' => 'scope',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_entity' => 'all'
        );

        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);

        $this->assertEqual(count($variables), 1);
        $scope = $variables[0];
        $this->assertIsA($scope, 'ReportScope');
        $this->assertEqual($scope->description, 'all available advertisers and publishers');
    }

    function testEntity_Publisher()
    {
        $import = array(
            'example' => array(
                'title' => 'Report on',
                'type' => 'scope',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_entity' => 'publisher',
            'example_publisher' => '316',
        );

        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);

        $this->assertEqual(count($variables), 1);
        $scope = $variables[0];
        $this->assertIsA($scope, 'ReportScope');
        $this->assertEqual($scope->description, 'publisher 316');
        $publisher_id = $scope->getPublisherId();
        $this->assertEqual($publisher_id, 316);
    }

    function testScope_Advertiser()
    {
        $import = array(
            'example' => array(
                'title' => 'Report on',
                'type' => 'scope',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_entity' => 'advertiser',
            'example_advertiser' => '420',
        );

        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);

        $this->assertEqual(count($variables), 1);
        $scope = $variables[0];
        $this->assertIsA($scope, 'ReportScope');
        $this->assertEqual($scope->description, 'advertiser 420');
        $publisher_id = $scope->getAdvertiserId();
        $this->assertEqual($publisher_id, 420);
    }

    function testScope_FunnyEntity()
    {
        $import = array(
            'example' => array(
                'title' => 'Report on',
                'type' => 'scope',
            ),
        );
        $info = array('plugin-import' => $import);
        $passed_in = array(
            'example_entity' => 'This_Is_Not_A_Valid_Choice'
        );

        $module = new ReportExecuteModule();
        $variables = $module->_getVariablesForReport($info, $passed_in);

        $this->assertError();
    }

    function testExecuteLegacy_Numbers()
    {
        Mock::generatePartial('Plugins_Reports', 'MockReportPlugin_ForExecuteModule_NumberTest', array('execute'));

        $module = new ReportExecuteModule();
        $report = new MockReportPlugin_ForExecuteModule_NumberTest($this);
        $report->expectOnce('execute', array(1, 2, 3));
        $passed_in = array(1, 2, 3);

        $module->_executeReportWithVariables($report, $passed_in);

        $report->tally();
    }

    function testExecuteLegacy_Strings()
    {
        Mock::generatePartial('Plugins_Reports', 'MockReportPlugin_ForExecuteModule_StringTest', array('execute'));

        $module = new ReportExecuteModule();
        $report = new MockReportPlugin_ForExecuteModule_StringTest($this);
        $report->expectOnce('execute', array('One', 'Two', 'Three'));
        $passed_in = array('One', 'Two', 'Three');

        $module->_executeReportWithVariables($report, $passed_in);

        $report->tally();
    }

    function testExecuteLegacy_Dates()
    {
        Mock::generatePartial('Plugins_Reports', 'MockReportPlugin_ForExecuteModule_DateTest', array('execute'));

        $module = new ReportExecuteModule();
        $report = new MockReportPlugin_ForExecuteModule_DateTest($this);
        $monday = new Date('2001-01-01');
        $tuesday = new Date('2001-01-02');
        $wednesday = new Date('2001-01-03');
        $report->expectOnce('execute', array($monday, $tuesday, $wednesday));
        $passed_in = array($monday, $tuesday, $wednesday);

        $module->_executeReportWithVariables($report, $passed_in);

        $report->tally();
    }
}

?>
