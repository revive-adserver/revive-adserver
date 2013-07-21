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

require_once LIB_PATH . '/Extension/reports/Reports.php';

/**
 * A plugin to generate a report showing the breakdown of delivery for the
 * admin user and any agencies in the system. The report contains a single
 * worksheet:
 *
 * 1. Agency Breakdown:
 *  - A breakdown of the delivery grouped by agency.
 *
 * In the above, "delivery" is:
 *  - Impressions
 *  - Clicks
 *  - Conversions
 *
 * @package    OpenXPlugin
 * @subpackage Reports
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Chris Nutting <chris@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Plugins_Reports_OxReportsAdmin_Breakdown extends Plugins_Reports
{

    /**
     * The local implementation of the initInfo() method to set all of the
     * required values for this report.
     */
    function initInfo()
    {
        $this->_name         = $this->translate("Manager Account Breakdown");
        $this->_description  = $this->translate("Lists Adviews/AdClicks/AdSales totals for a given month.");
        $this->_category     = 'admin';
        $this->_categoryName = $this->translate("Admin Reports");
        $this->_author       = 'Chris Nutting';
        $this->_export       = 'xls';
        $this->_authorize    = OA_ACCOUNT_ADMIN;

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
        global $strStartDate, $strEndDate, $strDelimiter;
        // Obtain the user's session-based default values for the report
        global $session;
        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        // Prepare the array for displaying the generation page
        $aImport = array (
            'period' => array(
                'title'   => $GLOBALS['strPeriod'],
                'type'    => 'date-month',
                'default' => $default_period_preset
            ),
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
        phpAds_SessionDataStore();
    }

    function execute($oDaySpan)
    {
        $this->isAllowedToExecute();
        // Prepare the range information for the report
        $this->_prepareReportRange($oDaySpan);
        // Prepare the report name
        $reportFileName = $this->_getReportFileName();
        // Prepare the output writer for generation
        $this->_oReportWriter->openWithFilename($reportFileName);
        // Add the worksheets to the report, as required
        $this->_addAgencyBreakdownWorksheet();
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
        $aParams += $this->_getDisplayableParametersFromDaySpan();
        return $aParams;
    }

    /**
     * A private method to create and add the "agency breakdown" worksheet
     * of the report.
     *
     * @access private
     */
    function _addAgencyBreakdownWorksheet()
    {
        // Manually prepare the header array
        global $strImpressions, $strClicks, $strConversions;
        $aHeaders = array(
            $this->translate("Manager") => 'text',
            $strImpressions => 'decimal',
            $strClicks      => 'decimal',
            $strConversions => 'decimal'
        );
        // Manually prepare the data array
        $aData = $this->_fetchData();
        // Add the worksheet
        $this->createSubReport(
            $this->translate("Manager Account Breakdown"),
            $aHeaders,
            $aData
        );
    }

    function _fetchData()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        // Save the date before convert it to UTC times to display it on the report
        $oStartDateToDisplay = new Date($this->_oDaySpan->oStartDate);
        $oEndDateToDisplay = new Date($this->_oDaySpan->oEndDate);
        // Ensure data is retrieved using UTC times
        $this->_oDaySpan->toUTC();
		// Get the manager account data
		$query = "
            SELECT
                g.name AS agency_name,
                SUM(s.impressions) AS impressions,
                SUM(s.clicks) AS clicks,
                SUM(s.conversions) AS conversions
            FROM
                {$aConf['table']['prefix']}{$aConf['table']['agency']} AS g,
                {$aConf['table']['prefix']}{$aConf['table']['clients']} AS c,
                {$aConf['table']['prefix']}{$aConf['table']['campaigns']} AS m,
                {$aConf['table']['prefix']}{$aConf['table']['banners']} AS b,
                {$aConf['table']['prefix']}{$aConf['table']['data_summary_ad_hourly']} AS s
            WHERE
                g.agencyid = c.agencyid
                AND
                c.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = s.ad_id
                AND
                s.date_time >= ". $oDbh->quote($this->_oDaySpan->getStartDateString('%Y-%m-%d %H:%M:%S'), 'date') ."
                AND
                s.date_time <= ". $oDbh->quote($this->_oDaySpan->getEndDateString('%Y-%m-%d %H:%M:%S'), 'date') ."
            GROUP BY
                agency_name";
        $aData = $oDbh->queryAll($query);
        if (PEAR::isError($aData)) {
            $aData = array();;
        }
        // Revert the date from UTC to the user selected value
        $this->_oDaySpan->oStartDate = $oStartDateToDisplay;
        $this->_oDaySpan->oEndDate = $oEndDateToDisplay;
        return $aData;
    }
}

?>
