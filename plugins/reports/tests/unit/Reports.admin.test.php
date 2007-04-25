<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

/**
 * Report interface tests for Openads
 */
class NullReport extends Plugins_Reports
{
    // Minimum possible implementation
    // (no implementation at all)
}

class PublisherOnlyReport extends Plugins_Reports
{
    function initInfo()
    {
        $this->_authorize = phpAds_Publisher;
    }
}

class AlwaysDisplayableNeverExecutableReport extends Plugins_Reports
{
    function isAllowedToDisplay()
    {
        return true;
    }

    function isAllowedToExecute()
    {
        return false;
    }
}

class LegacyPublisherOnlyReport extends Plugins_Reports
{
    function info()
    {
        $info = array(
            'plugin-name' => 'Old plugin',
            'plugin-authorize' => phpAds_Publisher,
        );
        return $info;
    }
}

class ReportTest extends UnitTestCase
{
    function testInstantiation()
    {
        $report = new NullReport();
        $this->assertNoErrors();
    }

    function testCannotExecuteByDefault()
    {
        $report = new NullReport();
        $this->assertFalse($report->isAllowedToExecute(), 'No report may be executed without permission being granted in some form');
    }

    function testCanExecuteWhenAuthorizeSet()
    {
        global $session;

        $session['usertype'] = phpAds_Publisher;
        $report = new PublisherOnlyReport();
        $this->assertTrue($report->isAllowedToExecute(), 'A publisher should be allowed to execute a publisher report');
    }

    function testCanDisplayWhenAuthorizeSet()
    {
        global $session;

        $session['usertype'] = phpAds_Publisher;
        $report = new PublisherOnlyReport();
        $this->assertTrue($report->isAllowedToDisplay(), 'A publisher should see a publisher report');
    }

    function testCannotExecuteWhenAuthorizeSetWrong()
    {
        global $session;

        $session['usertype'] = phpAds_Advertiser;
        $report = new PublisherOnlyReport();
        $this->assertFalse($report->isAllowedToExecute(), 'An advertiser should not be allowed to execute a publisher report');
    }

    function testCustomDisplayAuthorisationLogic()
    {
        $report = new AlwaysDisplayableNeverExecutableReport();
        $this->assertTrue($report->isAllowedToDisplay(), 'Custom report logic says to always allow displaying');
    }

    function testCustomExecuteAuthorisationLogic()
    {
        $report = new AlwaysDisplayableNeverExecutableReport();
        $this->assertFalse($report->isAllowedToExecute(), 'Custom report logic says to never allow execution');
    }

    function testLegacyStyleReportDisplaysAsRightUser()
    {
        global $session;

        $session['usertype'] = phpAds_Publisher;
        $report = new LegacyPublisherOnlyReport();
        $this->assertTrue($report->isAllowedToDisplay(), 'A publisher should see a publisher report, even if it is an old-style report');
    }
}

?>
