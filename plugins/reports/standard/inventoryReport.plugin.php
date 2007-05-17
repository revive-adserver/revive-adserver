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
$Id:inventoryReport.plugin.php 114 2006-03-03 14:32:10Z roh@m3.net $
*/

/**
 * @package    Plugins
 * @subpackage Reports
 * @author     Scott Switzer <scott@m3.net>
 */

require_once MAX_PATH . '/lib/max/Admin/Reporting/ZoneScope.php';
require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';
require_once MAX_PATH . '/plugins/reports/ExcelReports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';


class Plugins_Reports_Standard_InventoryReport extends Plugins_ExcelReports
{
    /* @var OA_Admin_DaySpan */
    var $_daySpan;

    /* @var int */
    var $_threshold;

    /* @var ZoneScope */
    var $_zoneId;
    /* @var PublisherId */
    var $_publisherId;

    /**
     * Provide plugin summary information to the framework when queried.
     */
    function initInfo()
    {
        $this->_name = 'Inventory Report';
        $this->_description = 'This report shows inventory by zone, domain, and page URL for the specified period.';
        $this->_category = 'standard';
        $this->_categoryName = 'Standard Reports';
        $this->_author = 'Scott Switzer';

        if ($this->hasZoneDomainPageForecasts()) {
            $this->_authorize = phpAds_Admin + phpAds_Agency + phpAds_Publisher;
        }

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
    }

    function hasZoneDomainPageForecasts()
    {
        if (phpAds_isUser(phpAds_Admin)) {
            $aParams = array();
        } elseif (phpAds_isUser(phpAds_Agency)) {
            $aParams = array('agency_id' => phpAds_getUserID());
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            $aParams = array('publisher_id' => phpAds_getUserID());
        }

        $aParams['zone_inventory_forecast_type'] = 1;
        $aZones = Admin_DA::getZones($aParams);
        $hasZoneDomainPageForecasts = (sizeof($aZones) > 0);
        return $hasZoneDomainPageForecasts;
    }

    function getDefaults()
    {
        global $session;

        $aImport = array();

        $default_zone = isset($session['prefs']['GLOBALS']['report_zone']) ? $session['prefs']['GLOBALS']['report_zone'] : '';
        $aImport['zone'] = array(
            'title' => MAX_Plugin_Translation::translate($GLOBALS['strZone'], $this->module, $this->package),
            'type' => 'zoneid-dropdown',
            'filter' => 'zone-inventory-domain-page-indexed',
            'default' => $default_zone
        );

        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'yesterday';
        $aImport['period'] = array(
            'title' => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
            'type' => 'date-month',
            'default' => $default_period_preset
        );

        $default_threshold = isset($session['prefs']['GLOBALS']['report_threshold']) ? $session['prefs']['GLOBALS']['report_threshold'] : 1000;
        $aImport['threshold'] = array(
            'title' => MAX_Plugin_Translation::translate('Suppress items with impressions less than this:', $this->module, $this->package),
            'type' => 'edit',
            'default' => $default_threshold,
            'size' => 10
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['zone'])) {
            $session['prefs']['GLOBALS']['report_zone'] = $_REQUEST['zone'];
        }
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset'] = $_REQUEST['period_preset'];
        }
        if (isset($_REQUEST['threshold'])) {
            $session['prefs']['GLOBALS']['report_threshold'] = $_REQUEST['threshold'];
        }
        phpAds_SessionDataStore();
    }

    /**
     * Validate $threshold value.
     */
    function _thresholdValidate()
    {
        if(!is_numeric($this->_threshold) || $this->_threshold < 0 || is_null($this->_threshold)) {
            $this->_threshold = 0;
        }
    }


    /**
     * Deliver the report to a browser.
     */
    function execute($zoneScope, $oDaySpan, $threshold)
    {

        //check if user is allowed to see zone data
        if(phpAds_isUser(phpAds_Admin)) {
            $aParams = array();
        } elseif (phpAds_isUser(phpAds_Agency)) {
            $aParams = array('agency_id' => phpAds_getUserID());
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            $aParams = array('publisher_id' => phpAds_getUserID());
        }
        $aZones = Admin_DA::getZones($aParams);

        if(is_array($aZones[$zoneScope])) {
            $this->_zoneId = $zoneScope == is_numeric($zoneScope) ? $zoneScope : false;
        } else {
            $this->_zoneId = false;
        }

        // Get variables
        $this->_daySpan = $oDaySpan;
        $this->_threshold = $threshold;
        $this->_publisherId = $this->dal->getPublisherIdByZoneId($this->_zoneId);

        //validate impressions input
        $this->_thresholdValidate();

        if (!$this->dal->obtainReportLock('InventoryReport')) {
            echo '
            <script language="javascript">
            alert("This report is currently locked by another user. Please try again later.");
            window.location="report-specifics.php?selection=standard:inventoryReport";
            </script>';
            exit();
        }

        // Initialise the Excel Report
        $this->openExcelReportWithDaySpan($oDaySpan);

        // fetch data
        if ($this->_zoneId) {
            $days_data = $this->dal->getEffectivenessForZoneByDay($this->_zoneId, $this->_daySpan, $this->_threshold);
            $domain_data = $this->dal->getEffectivenessForZoneByDomain($this->_zoneId, $this->_daySpan, $this->_threshold);
            $page_data = $this->dal->getEffectivenessForZoneByPage($this->_zoneId, $this->_daySpan, $this->_threshold);
        } else {
            $days_data = $this->dal->getEffectivenessForAllPublisherZonesByDay($this->_publisherId, $this->_daySpan, $this->_threshold);
            $domain_data = $this->dal->getEffectivenessForAllPublisherZonesByDomain($this->_publisherId, $this->_daySpan, $this->_threshold);
            $page_data = $this->dal->getEffectivenessForAllPublisherZonesByPage($this->_publisherId, $this->_daySpan, $this->_threshold);
            $allzone_data = $this->dal->getEffectivenessForAllPublisherZonesByZone($this->_publisherId, $this->_daySpan, $this->_threshold);
        }
        $dayzone_data = $this->dal->getEffectivenessForAllPublisherZonesByDayZoneDomain($this->_publisherId, $this->_daySpan, $this->_threshold);

        // Create the worksheets
        $this->addDailyEffectivenessSheet($days_data);
        $this->addDomainEffectivenessSheet($domain_data);
        $this->addPageEffectivenessSheet($page_data);
        $this->addDayZoneDomainSummarySheet($dayzone_data);
        if (!$this->_zoneId) {
            $this->addZoneEffectivenessSheet($allzone_data);
        }

        $this->closeExcelReport();
        $this->dal->releaseReportLock('InventoryReport');
    }

    /**
     * Collects a displayable array of parameter values used for this report.
     *
     * @todo Consider caching the results of _getZoneOwnerNames
     */
    function getReportParametersForDisplay()
    {
        if ($this->_zoneId) {
            $aPublisherInfo = $this->dal->getZoneOwnerNames($this->_zoneId);
        } else {
            $aPublisherInfo = $this->dal->getPublisherAndAgencyNamesForPublisherId($this->_publisherId);
        }
        $aReportParameters = array(
            'Agency' => $aPublisherInfo['agency_name'],
            'Publisher Name' => $aPublisherInfo['publisher_name'],
            'Zone Name' => $aPublisherInfo['zone_name']
        );
        if (!is_null($this->_daySpan)) {
            $aReportParameters['Start Date'] = $this->_daySpan->getStartDateString();
            $aReportParameters['End Date'] = $this->_daySpan->getEndDateString();
        }
        $aReportParameters['Minimum Impression Count'] = $this->_threshold;
        return $aReportParameters;
    }


    /**
     * Adds a worksheet to the report containing views and clicks for each day.
     *
     * @param Array $aReportParameters The values used to generate the report as a whole
     * @param Array $threshold The number of views to consider significant enough to include.
     */
    function addDailyEffectivenessSheet($days_data)
    {
        $headers = array(
            'Day' => 'date',
            'Views' => 'number',
            'Clicks' => 'number',
            '% CTR' => 'percent'
        );
        $days_display = $this->prepareDailyEffectivenessForDisplay($days_data);
        $this->createSubReport('Daily Breakdown', $headers, $days_display);
    }

    function addDomainEffectivenessSheet($domain_data)
    {
        $headers = array(
            'Domain' => 'text',
            'Views' => 'number'
        );
        $this->createSubReport('Domain Breakdown', $headers, $domain_data);
    }

    function addPageEffectivenessSheet($page_data)
    {
        $headers = array(
            'Domain' => 'text',
            'Page' => 'text',
            'Views' => 'number'
        );
        $this->createSubReport('Page Breakdown', $headers, $page_data);
    }

    function addZoneEffectivenessSheet($allzone_data)
    {
        $headers = array(
            'Zone' => 'text',
            'Size' => 'text',
            'Views' => 'number',
            'Clicks' => 'number',
            '% CTR' => 'percent'
        );
        $displayable_effectiveness = $this->prepareZoneEffectivenessForDisplay($allzone_data);
        $this->createSubReport('Zone Breakdown', $headers, $displayable_effectiveness);
    }

    function addDayZoneDomainSummarySheet($dayzone_data)
    {
        $headers = array(
            'Day' => 'date',
            'Zone' => 'text',
            'Domain' => 'text',
            'Views' => number
        );
        $this->createSubReport('Day Zone Domain breakdown', $headers, $dayzone_data);
    }

}

?>
