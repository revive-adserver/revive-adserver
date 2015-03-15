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
 * A plugin to generate a report showing the breakdown of delivery for a
 * given placement, for the supplied date range. The report can contain up
 * to three worksheets:
 *
 * 1. Daily Breakdown:
 *  - A breakdown of the delivery grouped by day.
 *
 * 2. Ad Breakdown:
 *  - A breakdown of the delivery grouped by ad name.
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
 */
class Plugins_Reports_OxReportsStandard_CampaignAnalysisReport extends Plugins_Reports
{

    /**
     * Local storage variable for the placement ID.
     *
     * @var integer
     */
    var $_placementId;

    /**
     * Local storage variable for the placement name.
     *
     * @var string
     */
    var $_placementName;

    /**
     * Local storage variable for the advertiser ID.
     *
     * @var integer
     */
    var $_advertiserId;

    /**
     * Local storage variable for the advertiser name.
     *
     * @var string
     */
    var $_advertiserName;

    /**
     * The local implementation of the initInfo() method to set all of the
     * required values for this report.
     */
    function initInfo()
    {
        $this->_name         = $this->translate("Campaign Analysis Report");
        $this->_description  = $this->translate("This report shows a breakdown of advertising for a particular campaign, by day, banner, and zone.");
        $this->_category     = 'standard';
        $this->_categoryName = $this->translate("Standard Reports");
        $this->_author       = 'Rob Hunter';
        $this->_export       = 'xls';
        $this->_authorize    = array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);

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
        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        $default_campaign      = isset($session['prefs']['GLOBALS']['report_campaign'])      ? $session['prefs']['GLOBALS']['report_campaign']      : '';
        // Prepare the array for displaying the generation page
        $aImport = array(
            'period'   => array(
                'title'   => $GLOBALS['strPeriod'],
                'type'    => 'date-month',
                'default' => $default_period_preset
            ),
            'campaign' => array(
                'title'   => $GLOBALS['strCampaign'],
                'type'    => 'campaignid-dropdown',
                'default' =>  $default_campaign
            ),
            'sheets'   => array(
                'title'   => $GLOBALS['strWorksheets'],
                'type'    => 'sheet',
                'sheets'  => array(
                    'daily_breakdown' => $this->translate("Daily Breakdown"),
                    'ad_breakdown'    => $this->translate("Ad Breakdown"),
                    'zone_breakdown'  => $this->translate("Zone Breakdown")
                )
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
            $session['prefs']['GLOBALS']['report_period_preset'] = $_REQUEST['period_preset'];
        }
        if (isset($_REQUEST['campaign'])) {
            $session['prefs']['GLOBALS']['report_campaign']      = $_REQUEST['campaign'];
        }
        phpAds_SessionDataStore();
    }

    /**
     * The local implementation of the execute() method to generate the report.
     *
     * @param OA_Admin_oDaySpan $oDaySpan    The OA_Admin_oDaySpan object for the report.
     * @param integer          $placementId The ID of the placement the report is for.
     * @param array            $aSheets     An array of sheets that should be in the report.
     */
    function execute($oDaySpan = null, $placementId = null, $aSheets = null)
    {
    	$checkResult = $this->_checkParameters($oDaySpan, $placementId, $aSheets);
    	if ($checkResult !== true) {
    		return $checkResult;
    	}
        // Save the placement ID for use later
        $this->_placementId = $placementId;
        // Locate and save the placement's name & owning advertiser
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $this->_placementId;
        $doCampaigns->find();
        if (!$doCampaigns->fetch()) {
            // Could not find the placement, set false
            // for the placement name, and the owning
            // advertiser ID and advertiser name
            $this->_placementName  = false;
            $this->_advertiserId   = false;
            $this->_advertiserName = false;
        } else {
            // Get and store the placement name and the
            // owning advertiser ID
            $aPlacement = $doCampaigns->toArray();
            $aPlacement['name'] = $aPlacement['campaignname'];
            $this->_placementName = MAX_getPlacementName($aPlacement);
            $this->_advertiserId  = $aPlacement['clientid'];
            if ($aPlacement['anonymous'] == 't') {
                $campaignAnonymous = true;
            } else {
                $campaignAnonymous = false;
            }
            // Get the owning advertiser's name
            $doClients = OA_Dal::factoryDO('clients');
            $doClients->clientid = $this->_advertiserId;
            $doClients->find();
            if (!$doClients->fetch()) {
                // Coule not find the owning advertiser name
                $this->_advertiserName = false;
            } else {
                // Store the owning advertiser name
                $aAdvertiser = $doClients->toArray();
                $this->_advertiserName = MAX_getAdvertiserName($aAdvertiser['clientname'], null, $campaignAnonymous);
            }
        }
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
        if (isset($aSheets['ad_breakdown'])) {
            $this->_addAdBreakdownWorksheet();
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
     * @param OA_Admin_oDaySpan $oDaySpan    The OA_Admin_oDaySpan object for the report.
     * @param integer          $placementId The ID of the placement the report is for.
     * @param array            $aSheets     An array of sheets that should be in the report.
     * @return bool|int - True if no errors, error code otherwise
     */
    function _checkParameters($oDaySpan, $placementId, $aSheets)
    {
        if (!isset($aSheets['daily_breakdown']) &&
            !isset($aSheets['ad_breakdown']) &&
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
        if ($this->_advertiserName !== false) {
            $key = $GLOBALS['strClient'];
            $aParams[$key] = $this->_advertiserName;
        }
        if ($this->_placementName !== false) {
            $key = $GLOBALS['strCampaign'];
            $aParams[$key] = $this->_placementName;
        }
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
        $_REQUEST['clientid'] = $this->_advertiserId;
        $_REQUEST['campaignid'] = $this->_placementId;
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $controllerType = 'affiliate-campaign-history';
        } else {
            $controllerType = 'campaign-history';
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
     * A private method to create and add the "ad breakdown" worksheet
     * of the report.
     *
     * @access private
     */
    function _addAdBreakdownWorksheet()
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
        $_REQUEST['clientid'] = $this->_advertiserId;
        $_REQUEST['campaignid'] = $this->_placementId;
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $controllerType = 'affiliate-campaigns';
            $_REQUEST['startlevel'] = 1;
        } else {
            $controllerType = 'campaign-banners';
        }
        // Get the header and data arrays from the same statistics controllers
        // that prepare stats for the user interface stats pages
        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controllerType);
        // Add the worksheet
        $this->createSubReport(
            $this->translate("Ad Breakdown"),
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
        $_REQUEST['clientid'] = $this->_advertiserId;
        $_REQUEST['campaignid'] = $this->_placementId;
        // Select the correct statistics page controller type
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $controllerType = 'affiliate-zones';
        } else {
            $controllerType = 'campaign-affiliates';
            $_REQUEST['startlevel'] = 1;
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
