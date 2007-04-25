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

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';
require_once MAX_PATH . '/plugins/reportWriter/output/ExcelReportWriter.plugin.php';
require_once 'Date.php';

/**
 *
 * Plugins_Reports is an abstract class for every Report plugin
 *
 * @static
 */
class Plugins_ExcelReports extends EnhancedReport
{
    // PHP4-style constructor
    function Plugins_ExcelReports()
    {
        parent::EnhancedReport();
        $this->_export = 'xls';
        //$this->_report_writer = new HtmlReportWriter();
        $this->_report_writer = new Plugins_ReportWriter_Output_ExcelReportWriter();
    }

    /**
     * @todo Rename this method to openExcelReportWithDates
     * @todo Remove this method entirely
     * @todo Replace these individual methods with ReportWriter interface:
     *       openReport() getFilename() closeReport() deliverReport()
     * @deprecated Mar 1, 2006
     */
    function openExcelReport($oStartDate, $oEndDate)
    {
        $reportName = $this->_name . ' from ' . $oStartDate->format('%Y-%b-%d') . ' to ' . $oEndDate->format('%Y-%b-%d') . '.xls';
        $this->_report_writer->openWithFilename($reportName);
    }
    function openExcelReportWithDaySpan($oDaySpan)
    {
        $startDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getStartDateString())): 'Beginning';
        $endDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getEndDateString())): date('Y-M-d');
        $reportName = $this->_name . ' from ' . $startDate . ' to ' . $endDate . '.xls';
        $this->_report_writer->openWithFilename($reportName);
    }
    function closeExcelReport()
    {
        $this->_report_writer->closeAndSend();
    }

    /**
     * @todo Remove this method -- callers should use EnhancedReport::createSubReport
     * @deprecated Mar 2, 2006
     */
    function createReportWorksheet($name, $reportTitle, $aReportParameters, $firstColSize = 8)
    {
        return $this->_report_writer->createReportWorksheet($name, $reportTitle, $aReportParameters, $firstColSize);
    }

    /**
     * @todo Remove this method -- callers should use EnhancedReport::createSubReport
     * @deprecated Mar 2, 2006
     */
    function createReportSection($name, $reportDataTitle, $aReportDataHeaders, $aReportData, $colSize = 25, $addFormat)
    {
        return $this->_report_writer->createReportSection($name, $reportDataTitle, $aReportDataHeaders, $aReportData, $colSize, $addFormat);
    }
}
?>
