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

// Include required files
require_once LIB_PATH . '/Extension/reports/ReportsScope.php';

/**
 * A plugin to generate a report showing the breakdown of delivery for a
 * given advertiser and/or publisher, for the supplied date range. The report
 * can contain up to three worksheets:
 *
 * 1. Daily Breakdown:
 *  - A breakdown of the delivery grouped by day.
 *
 * 2. Campaign Breakdown:
 *  - A breakdown of the delivery grouped by campaign name.
 *
 * 3. Zone Breakdown:
 *  - A breakdown of the delivery grouped by zone name.
 *
 * In all cases, "delivery" is the set of all data selected to be displayed
 * by the user's preferences, and can consist of the following items:
 *  - Requests
 *  - Impressions
 *  - Clicks
 *  - CTR: The click through ratio
 *  - Conversions
 *  - Pending Conversions
 *  - Impression SR: The impressions to sales ratio
 *  - Click SR: The clicks to sales ratio
 *  - Revenue
 *  - Cost
 *  - Basket Value: Of conversions
 *  - Number of Items: In conversions
 *  - Revenue CPC: Revenue per click
 *  - ERPM
 *  - ERPC
 *  - ERPS
 *  - EIPM
 *  - EIPC
 *  - EIPS
 *  - EPPM
 *  - EPPC
 *  - EPPS
 *  - ECPM
 *  - ECPC
 *  - ECPS
 *
 * @package    OpenXPlugin
 * @subpackage Reports
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Robert Hunter <roh@m3.net>
 */
class Plugins_Reports_OxReportsStandard_AdvertisingAnalysisReport extends Plugins_ReportsScope
{

    /**
     * The local implementation of the initInfo() method to set all of the
     * required values for this report.
     */
    function initInfo()
    {
        $this->_name         = $this->translate("Advertising Analysis Report");
        $this->_description  = $this->translate("This report shows a breakdown of advertising for a particular advertiser or website, by day, campaign, and zone.");
        $this->_category     = 'standard';
        $this->_categoryName = $this->translate("Standard Reports");
        $this->_author       = 'Rob Hunter';
        $this->_export       = 'xls';
        $this->_authorize    = array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);

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
        // Prepare which worksheets can be in the report
        $aSheets = array(
            'daily_breakdown'    => $this->translate("Daily Breakdown"),
            'campaign_breakdown' => $this->translate("Campaign Breakdown")
        );
        $aSheets['zone_breakdown'] = $this->translate("Zone Breakdown");
        // Prepare the array for displaying the generation page
        $aImport = array(
            'period' => array(
                'title'            => $GLOBALS['strPeriod'],
                'type'             => 'date-month',
                'default'          => $default_period_preset
            ),
            'scope'  => array(
                'title'            => $GLOBALS['strLimitations'],
                'type'             => 'scope',
                'scope_advertiser' => $default_scope_advertiser,
                'scope_publisher'  => $default_scope_publisher
            ),
            'sheets' => array(
                'title'            => $GLOBALS['strWorksheets'],
                'type'             => 'sheet',
                'sheets'           => $aSheets
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
     * @param OA_Admin_DaySpan $oDaySpan The OA_Admin_DaySpan object for the report.
     * @param Admin_UI_OrganisationScope $oScope The advertiser/publisher scope limitation object.
     * @param array $aSheets  An array of sheets that should be in the report.
     */
    function execute($oDaySpan, $oScope, $aSheets)
    {
        $checkResult = $this->_checkParameters($oDaySpan, $oScope, $aSheets);
        if ($checkResult !== true) {
            return $checkResult;
        }

        // Save the scope for use later
        $this->_oScope = $oScope;
        // Prepare the range information for the report
        $this->_prepareReportRange($oDaySpan);
        // Prepare the report name
        $reportFileName = $this->_getReportFileName();
        // Prepare the output writer for generation
        $this->_oReportWriter->openWithFilename($reportFileName);
        // Add the worksheets to the report, as required
        if (isset($aSheets['daily_breakdown'])) {
            $this->_addDailyBreakdownWorksheet();
        }
        if (isset($aSheets['campaign_breakdown'])) {
            $this->_addCampaignBreakdownWorksheet();
        }
        if (isset($aSheets['zone_breakdown'])) {
            $this->_addZoneBreakdownWorksheet();
        }
        // Close the report writer and send the report to the user
        $this->_oReportWriter->closeAndSend();
    }

    /**
     * Check input parameters
     *
     * @param OA_Admin_DaySpan $oDaySpan The OA_Admin_DaySpan object for the report.
     * @param Admin_UI_OrganisationScope $oScope The advertiser/publisher scope limitation object.
     * @param array $aSheets  An array of sheets that should be in the report.
     *
     * @return bool|int - True if no errors, error code otherwise
     */
    function _checkParameters($oDaySpan, $oScope, $aSheets)
    {
        if (!isset($aSheets['daily_breakdown']) &&
            !isset($aSheets['campaign_breakdown']) &&
            !isset($aSheets['zone_breakdown']))
        {
            return PLUGINS_REPORTS_MISSING_SHEETS_ERROR;
        }
        return true;
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
     * A private method to create and add the "daily breakdown" worksheet
     * of the report.
     *
     * @access private
     */
    function _addDailyBreakdownWorksheet()
    {
        // Prepare the $_REQUEST array as if it was set up via the stats.php page
        if (is_null($this->_oDaySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_oDaySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_oDaySpan->getEndDateString();
        }
        $_REQUEST['breakdown'] = 'day';
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
            if (!empty($this->_oScope->_advertiserId) && !empty($this->_oScope->_publisherId)) {
                $controllerType = 'advertiser-affiliate-history';
            } elseif (!empty($this->_oScope->_advertiserId)) {
                $controllerType = 'advertiser-history';
            } elseif (!empty($this->_oScope->_publisherId)) {
                $controllerType = 'affiliate-history';
            } else {
                $controllerType = 'global-history';
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            if (!empty($this->_oScope->_publisherId)) {
                $controllerType = 'advertiser-affiliate-history';
            } else {
                $controllerType = 'advertiser-history';
            }
        } else {
            $controllerType = 'affiliate-history';
        }
        if (!empty($this->_oScope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_oScope->_advertiserId;
        }
        if (!empty($this->_oScope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_oScope->_publisherId;
        }
        // Get the header and data arrays from the same statistics controllers
        // that prepare stats for the user interface stats pages
        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controllerType);
        // Add the worksheet
        $this->createSubReport(
            $this->translate("Daily Breakdown"),
            $aHeaders,
            $aData
        );
    }

    /**
     * A private method to create and add the "camapign breakdown" worksheet
     * of the report.
     *
     * @access private
     */
    function _addCampaignBreakdownWorksheet()
    {
        // Prepare the $_REQUEST array as if it was set up via the stats.php page
        if (is_null($this->_oDaySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_oDaySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_oDaySpan->getEndDateString();
        }
        $_REQUEST['expand']     = 'none';
        $_REQUEST['startlevel'] = 0;
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
            if (!empty($this->_oScope->_advertiserId)) {
                $controllerType = 'advertiser-campaigns';
            } elseif (!empty($this->_oScope->_publisherId)) {
                $controllerType = 'affiliate-campaigns';
            } else {
                $controllerType = 'global-advertiser';
                $_REQUEST['startlevel'] = 1;
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $controllerType = 'advertiser-campaigns';
        } else {
            $controllerType = 'affiliate-campaigns';
        }
        if (!empty($this->_oScope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_oScope->_advertiserId;
        }
        if (!empty($this->_oScope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_oScope->_publisherId;
        }
        // Get the header and data arrays from the same statistics controllers
        // that prepare stats for the user interface stats pages
        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controllerType);
        // Add the worksheet
        $this->createSubReport(
            $this->translate("Campaign Breakdown"),
            $aHeaders,
            $aData
        );
    }

    /**
     * A private method to create and add the "zone breakdown" worksheet
     * of the report.
     *
     * @access private
     */
    function _addZoneBreakdownWorksheet()
    {
        // Prepare the $_REQUEST array as if it was set up via the stats.php page
        if (is_null($this->_oDaySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_oDaySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_oDaySpan->getEndDateString();
        }
        $_REQUEST['expand']     = 'none';
        $_REQUEST['startlevel'] = 0;
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
            if (!empty($this->_oScope->_advertiserId)) {
                $controllerType = 'advertiser-affiliates';
                $_REQUEST['startlevel'] = 1;
            } elseif (!empty($this->_oScope->_publisherId)) {
                $controllerType = 'affiliate-zones';
            } else {
                $controllerType = 'global-affiliates';
                $_REQUEST['startlevel'] = 1;
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $controllerType = 'advertiser-affiliates';
            $_REQUEST['startlevel'] = 1;
        } else {
            $controllerType = 'affiliate-zones';
        }
        if (!empty($this->_oScope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_oScope->_advertiserId;
        }
        if (!empty($this->_oScope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_oScope->_publisherId;
        }
        // Get the header and data arrays from the same statistics controllers
        // that prepare stats for the user interface stats pages
        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controllerType);
        // Add the worksheet
        $this->createSubReport(
            $this->translate("Zone Breakdown"),
            $aHeaders,
            $aData
        );
    }

}

?>