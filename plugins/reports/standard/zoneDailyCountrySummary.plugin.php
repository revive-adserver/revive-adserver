<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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


class Plugins_Reports_Standard_ZoneDailyCountrySummary extends Plugins_ExcelReports
{
    /* @var DaySpan */
    var $_daySpan;

    /* @var int */
    var $_reslimit;

    /* @var ZoneScope */
    var $_zoneId;
    /* @var PublisherId */
    var $_publisherId;

    /**
     * Provide plugin summary information to the framework when queried.
     */
    function initInfo()
    {
        $this->_name = 'Zone Daily Country Summary';
        $this->_description = 'This report shows ad impressions and clicks by zone and country for the specified period.';
        $this->_category = 'standard';
        $this->_categoryName = 'Standard Reports';
        $this->_author = 'James Easterby';

        if ($this->hasZoneCountryForecasts()) {
            $this->_authorize = phpAds_Admin + phpAds_Agency + phpAds_Publisher;
        }

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
    }

    function hasZoneCountryForecasts()
    {
        if (phpAds_isUser(phpAds_Admin)) {
            $aParams = array();
        } elseif (phpAds_isUser(phpAds_Agency)) {
            $aParams = array('agency_id' => phpAds_getUserID());
        } elseif (phpAds_isUser(phpAds_Publisher)) {
            $aParams = array('publisher_id' => phpAds_getUserID());
        }

        $aParams['zone_inventory_forecast_type'] = 2;
        $aZones = Admin_DA::getZones($aParams);
        $hasZoneCountryForecasts = (sizeof($aZones) > 0);
        return $hasZoneCountryForecasts;
    }

    function getDefaults()
    {
        global $session;

        $aImport = array();

        $default_zone = isset($session['prefs']['GLOBALS']['report_zone']) ? $session['prefs']['GLOBALS']['report_zone'] : '';
        $aImport['zone'] = array(
            'title' => MAX_Plugin_Translation::translate($GLOBALS['strZone'], $this->module, $this->package),
            'type' => 'zoneid-dropdown',
            'filter' => 'zone-inventory-country-indexed',
            'default' => $default_zone
        );

        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'yesterday';
        $aImport['period'] = array(
            'title' => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
            'type' => 'date-month',
            'default' => $default_period_preset
        );


        $default_reslimit_preset = isset($session['prefs']['GLOBALS']['report_reslimit_preset']) ? $session['prefs']['GLOBALS']['report_reslimit_preset'] : 'All';
        $aImport['reslimit'] = array(
            'title' => MAX_Plugin_Translation::translate('Result Limit', $this->module, $this->package),
            'type' => 'dropdown',
            'field_selection_names' => array('none' => 'None', '10' => 'Top 10', '100' => 'Top 100', '500' => 'Top 500'),
            'default' => $default_reslimit_preset
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
        if (isset($_REQUEST['reslimit_preset'])) {
            $session['prefs']['GLOBALS']['report_reslimit_preset'] = $_REQUEST['reslimit_preset'];
        }
        phpAds_SessionDataStore();
    }

    /**
     * Deliver the report to a browser.
     */
    function execute($zoneScope, $oDaySpan, $reslimit)
    {
        // Get variables
        $this->_daySpan = $oDaySpan;
        $this->_zoneId = $zoneScope == is_numeric($zoneScope) ? $zoneScope : false;
        $this->_reslimit = $reslimit;
        $this->_publisherId = $this->dal->getPublisherIdByZoneId($this->_zoneId);

        // Initialise the Excel Report
        $this->openExcelReportWithDaySpan($oDaySpan);

        // Create the worksheets
        $this->addDailyCountryEffectivenessSheet();

        $this->closeExcelReport();
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
        $aReportParameters['Result Limit'] = $this->_reslimit.' ';
        return $aReportParameters;
    }

    /**
     * Adds a worksheet to the report containing views and clicks for each day/country.
     */
    function addDailyCountryEffectivenessSheet()
    {
        $headers = array(
            'Day' => 'date',
            'Country' => 'text',
            'Views' => 'number',
            'Clicks' => 'number',
            '% CTR' => 'percent'
        );

        $days_data = $this->dal->getEffectivenessForZoneByDayCountry($this->_zoneId, $this->_daySpan, $this->_reslimit);
        $days_display = $this->prepareDailyCountryEffectivenessForDisplay($days_data);

        $this->createSubReport('Daily Country Breakdown', $headers, $days_display);
    }

}
?>
