<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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
$Id$
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Entities.php';
require_once MAX_PATH . '/lib/max/Dal/Statistics.php';
require_once MAX_PATH . '/lib/max/Entity/Placement.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressions.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once MAX_PATH . '/lib/max/Plugin/DeliveryLimitations/MatchOverlap.php';
require_once MAX_PATH . '/plugins/reports/lib.php';
require_once MAX_PATH . '/plugins/reports/Reports.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once 'Date.php';
require_once 'Date/Span.php';
require_once 'Spreadsheet/Excel/Writer.php';

require_once MAX_PATH . '/lib/max/Admin/Reporting/ZoneScope.php';
require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';
require_once MAX_PATH . '/plugins/reports/ExcelReports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Andrew Hill <andrew@m3.net>
 *
 * A plugin to generate publisher availability reports, showing the available
 * inventory in a channel (for either all of the publisher's zones, or a specific
 * zone), over a given period.
 */
class Plugins_Reports_Publisher_ChannelAvailability extends Plugins_ExcelReports {

    /**
     * A local instance of the MAX_Dal_Entities class.
     *
     * @var MAX_Dal_Entities
     */
    var $oMaxDalEntities;

    /**
     * A local instance of the MAX_Dal_Statistics class.
     *
     * @var MAX_Dal_Statistics
     */
    var $oMaxDalStatistcs;

    /**
     * A local instance of the MAX_Plugin_DeliveryLimitations_MatchOverlap class.
     *
     * @var MAX_Plugin_DeliveryLimitations_MatchOverlap
     */
    var $oMaxPluginDeliveryLimitationsMatchOverlap;

    /**
     * An array to store table index to types of data values.
     *
     * @var array
     */
    var $aTypes = array(
        'impression' => 'impressions',
        'click'      => 'clicks',
        'conversion' => 'conversions'
    );

    /**
     * The publisher ID of the report.
     *
     * @var integer
     */
    var $publisherId;

    /**
     * The channel ID of the report.
     *
     * @var integer
     */
    var $channelId;

    /**
     * The threshold value for the report
     *
     * @var integer
     */
    var $threshold;

    /**
     * A string to store an error message - set in the event that the
     * report cannot be generated.
     *
     * @var string
     */
    var $error;

    /**
     * An array for storing the start and end dates of the report period.
     *
     * @var array
     */
    var $aPeriod;

    /**
     * An array of the zone(s) to be used in the report.
     *
     * @var array
     */
    var $aZoneIds;

    /**
     * The name of the single zone the report is for, or "All Zones".
     *
     * @var string
     */
    var $zoneName;

    /**
     * An array, indexed by zone ID, of the zone names.
     *
     * @var array
     */
    var $aZoneDetails;

    /**
     * An array, indexed by zone ID, then date, to store the channel/zone
     * inventory (impression) forecast values for each day in the report
     * period.
     *
     * @var array
     */
    var $aChannelForecastsDaily;

    /**
     * An array, indexed by zone ID, to store the channel/zone inventory
     * (impression) forecast values for the report period, based on the
     * daily inventory (impression) forecast values for the channel/zone(s).
     *
     * @var array
     */
    var $aChannelForecastsPeriod;

    /**
     * An array, indexed by zone ID, to store the recent average zone
     * inventory (impression) forecast values.
     *
     * @var array
     */
    var $aAverageZoneForecasts;

    /**
     * An array, indexed by zone ID, to store the zone inventory (impression)
     * forecast values for the report period, based on the recent average zone
     * inventory (impression) forecast values.
     *
     * @var array
     */
    var $aZoneForecastsPeriod;

    /**
     * An array, indexed by zone ID, of the active ad(s) that are linked to
     * the zone(s) in the report.
     *
     * @var array
     */
    var $aZoneAdIds;

    /**
     * An array, indexed by ad ID, of the active ad(s) that are linked to
     * the zone(s) in the report.
     *
     * @var array
     */
    var $aAdIds;

    /**
     * An array, indexed by placement ID, of placement details, where the
     * placements will be active during the report period, and have at least
     * one child ad which is linked to (one of) the zone(s) in the report.
     *
     * @var array
     */
    var $aPlacements;

    /**
     * An array, indexed by placement ID, of ad detials, including any ad delivery
     * limitations, of ALL children ads in the placements.
     *
     * @var array
     */
    var $aPlacementAds;

    /**
     * An array, indexed by ad ID, of the zones the ads are linked to.
     *
     * @var array
     */
    var $aAdZoneIds;

    /**
     * The number of days the report period covers.
     *
     * @var integer
     */
    var $reportPeriodDays;

    /**
     * An array to store temporary information about the number of booked
     * impressions required by placements and ads that (may) need to be
     * allocated to the channel/zone(s) in the report.
     *
     * @var array
     */
    var $aBookingInfo;

    /**
     * An array, indexed by placement ID, then zone ID, of booked impression
     * inventory in the channel resulting from run of site ads in exclusive
     * placements.
     *
     * @var array
     */
    var $aExclusivePlacementsRunOfSiteBookings;

    /**
     * An array, indexed by placement ID, then zone ID, of booked impression
     * inventory in the channel resulting from targeted ads in the channel, in
     * exclusive placements.
     *
     * @var array
     */
    var $aExclusivePlacementsChannelBookings;

    /**
     * An array, indexed by placement ID, then zone ID, of booked impression
     * inventory in the channel resulting from targeted ads with channel
     * overlap, in exclusive placements.
     *
     * @var array
     */
    var $aExclusivePlacementsTargetedBookings;

    /**
     * An array, indexed by placement ID, then zone ID, of booked impression
     * inventory in the channel resulting from run of site ads in high-priority
     * placements.
     *
     * @var array
     */
    var $aHighPriorityPlacementsRunOfSiteBookings;

    /**
     * An array, indexed by placement ID, then zone ID, of booked impression
     * inventory in the channel resulting from targeted ads in the channel, in
     * high-priority placements.
     *
     * @var array
     */
    var $aHighPriorityPlacementsChannelBookings;

    /**
     * An array, indexed by placement ID, then zone ID, of booked impression
     * inventory in the channel resulting from targeted ads with channel
     * overlap, in high-priority placements.
     *
     * @var array
     */
    var $aHighPriorityPlacementsTargetedBookings;


    /**
     * The class constructor method.
     *
     * @return Plugins_Reports_Publisher_ChannelAvailability
     */
    function Plugins_Reports_Publisher_ChannelAvailability()
    {
        $this->_export = 'xls';
        $this->_useDefaultDal();
        $this->oMaxDalEntities = &$this->_getMAX_Dal_Entities();
        $this->oMaxDalStatistcs = &$this->_getMAX_Dal_Statistics();
        $this->oMaxPluginDeliveryLimitationsMatchOverlap = new MAX_Plugin_DeliveryLimitations_MatchOverlap();
        $this->aExclusivePlacementsRunOfSiteBookings    = array();
        $this->aExclusivePlacementsChannelBookings      = array();
        $this->aExclusivePlacementsTargetedBookings     = array();
        $this->aHighPriorityPlacementsRunOfSiteBookings = array();
        $this->aHighPriorityPlacementsChannelBookings   = array();
        $this->aHighPriorityPlacementsTargetedBookings  = array();
    }

    /**
     * A private method to get an instance of the MAX_Dal_Entities class.
     *
     * @access private
     * @return MAX_Dal_Entities
     */
    function &_getMAX_Dal_Entities()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Entities');
        if (!$oDal) {
            $oDal = new MAX_Dal_Entities();
            $oServiceLocator->register('MAX_Dal_Entities', $oDal);
        }
        return $oDal;
    }

    /**
     * A private method to get an instance of the MAX_Dal_Statistics class.
     *
     * @access private
     * @return MAX_Dal_Statistics
     */
    function &_getMAX_Dal_Statistics()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('MAX_Dal_Statistics');
        if (!$oDal) {
            $oDal = new MAX_Dal_Statistics();
            $oServiceLocator->register('MAX_Dal_Statistics', $oDal);
        }
        return $oDal;
    }

    /**
     * A private method to get an instance of the OA_Dal_Maintenance_Priority class.
     *
     * @access private
     * @return OA_Dal_Maintenance_Priority
     */
    function &_getOA_Dal_Maintenance_Priority()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
        if (!$oDal) {
            $oDal = new OA_Dal_Maintenance_Priority();
            $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        }
        return $oDal;
    }

    /**
     * A method to set this plugin's private variables with the required
     * details about the plugin.
     */
    function initInfo()
    {
        global $session;

        $this->_name         = MAX_Plugin_Translation::translate('Channel Availability Report', $this->module, $this->package);
        $this->_description  = MAX_Plugin_Translation::translate('Provides a breakdown of the forecast inventory, booked inventory and availabie inventory for channels.', $this->module, $this->package);
        // add error message if there is one
        if (isset($session['reports']['errormsg'])) {
            $this->_errormsg  = '<br /><br />'.$session['reports']['errormsg'].'';
            unset($session['reports']['errormsg']);
            phpAds_SessionDataStore();
        }
        $this->_description .= $this->_errormsg;
        $this->_category     = 'publisher';
        $this->_categoryName = MAX_Plugin_Translation::translate('Publisher Reports', $this->module, $this->package);
        $this->_author       = 'Andrew Hill';
        $this->_export       = 'csv';
        $this->_authorize    = phpAds_Admin+phpAds_Agency+phpAds_Affiliate;
        $this->_import       = $this->_getImport();
        $this->_saveDefaults();
    }

    /**
     * A private method prepare and return an array containing the details
     * required to display the report's input value form in the UI.
     *
     * @access private
     * @return array An array containing the details required for displaying
     *               the report's input value form in the UI.
     */
    function _getImport()
    {
        // Import the user's session
        global $session;

        // Set default values from user's session
        $default_publisher = isset($session['prefs']['GLOBALS']['report_publisher']) ? $session['prefs']['GLOBALS']['report_publisher'] : '';
        $default_channel = isset($session['prefs']['GLOBALS']['report_channel']) ? $session['prefs']['GLOBALS']['report_channel'] : '';
        $default_zone = isset($session['prefs']['GLOBALS']['report_zone']) ? $session['prefs']['GLOBALS']['report_zone'] : 'all';
        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'next_month';
        $default_threshold = isset($session['prefs']['GLOBALS']['report_threshold']) ? $session['prefs']['GLOBALS']['report_threshold'] : 1000;

        // Import the globally defined strings for "Publisher", "Channel", "Zone"
        global $strAffiliate, $strChannel, $strZone;

        // Prepare the report's input value form data array
        $aImport = array (
            'publisherId'  => array (
                'title'                 => MAX_Plugin_Translation::translate(
                    $strAffiliate,
                    $this->module,
                    $this->package
                ),
                'type'                  => 'affiliateid-dropdown',
                'default'               => $default_publisher
            ),
            'channelId'    => array (
                'title'                 => MAX_Plugin_Translation::translate(
                    $strChannel,
                    $this->module,
                    $this->package
                ),
                'type'                  => 'channelid-dropdown',
                'default'               => $default_channel
            ),
            'zoneId'       => array (
                'title'                 => MAX_Plugin_Translation::translate(
                    $strZone,
                    $this->module,
                    $this->package
                ),
                'type'                  => 'zone-scope',
                'filter'                => 'zone-inventory-channel-indexed',
                'default'               => $default_zone
            ),
            'period'    => array (
                'title'                 => MAX_Plugin_Translation::translate(
                    'Period',
                    $this->module,
                    $this->package
                ),
                'type'                  => 'date-month',
                'field_selection_names' => array(
                    'this_month_remainder'  => MAX_Plugin_Translation::translate(
                        'Remainder of this month',
                        $this->module,
                        $this->package
                    ),
                    'next_month'            => MAX_Plugin_Translation::translate(
                        'Next month',
                        $this->module,
                        $this->package
                    ),
                    'specific'              => MAX_Plugin_Translation::translate(
                        'Custom values',
                        $this->module,
                        $this->package
                    ),
                ),
                'default'               => $default_period_preset
            ),
            'threshold' => array(
                'title'                 => MAX_Plugin_Translation::translate(
                    'Suppress items where value less than',
                    $this->module,
                    $this->package
                ),
                'type'                  => 'edit',
                'default'               => $default_threshold,
                'size'                  => 10
            )
        );
        return $aImport;
    }

    /**
     * A private method to save the user's default values to use for the
     * report in their session.
     *
     * @access private
     */
    function _saveDefaults()
    {
        // Import the user's session
        global $session;

        // Save the session data required
        if (isset($_REQUEST['publisherId'])) {
            $session['prefs']['GLOBALS']['report_publisher'] = $_REQUEST['publisherId'];
        }
        if (isset($_REQUEST['channelId'])) {
            $session['prefs']['GLOBALS']['report_channel'] = $_REQUEST['channelId'];
        }
        if (isset($_REQUEST['zoneId'])) {
            $session['prefs']['GLOBALS']['report_zone'] = $_REQUEST['zoneId'];
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
     * The method to generate the report.
     *
     * @param integer $publisherId The ID of the publisher the report is being generated for.
     * @param integer $channelId The ID of the channel that the report is being generated for.
     * @param mixed $zoneId The ID of the zone that the report is being generated for, as an
     *                      integer, or the string "all" if the report should show all zones
     *                      in the publisher.
     * @param DaySpan $oDaySpan An object representing the start and end dates of the report
     *                          period.
     * @param integer $threshold The minimum count value - don't display values less than this.
     */
    function execute($publisherId, $channelId, $zoneId, $oDaySpan, $threshold)
    {
        global $session;

        // Prepare the parameters in the required format
        $this->publisherId = $publisherId;
        $this->channelId = $channelId;
        $aZoneIds = array();
        if ($zoneId != 'all') {
            $aZoneIds[] = $zoneId;
        }
        $aPeriod = array();
        $aPeriod['start'] = $oDaySpan->_startDate;
        $aPeriod['end']   = $oDaySpan->_endDate;
        $this->aPeriod = $aPeriod;
        $this->threshold = $threshold;
        // Prepare the raw data required for the report
        $result = $this->_prepareRawData($aZoneIds);
        unset($session['reports']['errormsg']);
        phpAds_SessionDataStore();
        // refresh page if error
        if (!$result) {
            $session['reports']['errormsg'] = '<font color="#FF0000">Error: '.$this->error.'</font>';
            phpAds_SessionDataStore();
            echo '<script language="javascript">window.location="'.$_REQUEST['refresh_page'].'"</script>';
            exit(); // just in case
        }
        // Set the channel/zone(s) inventory forecasts
        $this->_setChannelZoneInventoryForecasts();
        // Set the zone(s) inventory forecasts
        $this->_setZoneInventoryForecasts();
        // Set the booked inventory
        $this->_setBookedInventory();
        // Generate the report
        $this->_generateReport();
    }

    function _generateReport()
    {
        // Initialise the Excel Report
        $this->openExcelReportWithDaySpan($oDaySpan);
        // Create the worksheet and close output
        $this->addWorksheet();
        $this->closeExcelReport();
    }


    /**
     * Collects a displayable array of parameter values used for this report.
     */
    function getReportParametersForDisplay()
    {
        $strStartDate = $this->aPeriod['start']->year.'-'.$this->aPeriod['start']->month.'-'.$this->aPeriod['start']->day;
        $strEndDate = $this->aPeriod['end']->year.'-'.$this->aPeriod['end']->month.'-'.$this->aPeriod['end']->day;
        $aReportParameters['Channel'] =  $this->channel_info['name'].' ['.$this->channelId.']';
        $strZoneId = count($this->aZoneIds) == 1 ? '['.$this->aZoneIds[0].']': '';
        $aReportParameters['Zone'] = $this->zoneName.' '.$strZoneId;
        $aReportParameters['Start Date'] = $strStartDate;
        $aReportParameters['End Date'] = $strEndDate;
        $aReportParameters['Minimum Impression Count'] = $this->threshold.' ';

        return $aReportParameters;
    }


    /**
     * Adds a worksheet to the report
     */
    function addWorksheet()
    {
        /*
         * Available Inventory Report
         * --------------------------
         * Agency Name:              Not yet set - can this be passed in as a parameter?
         * Publisher Name:           Not yet set - can this be passed in as a parameter?
         * Channel ID:               $this->channelId
         * Channel Name:             Not yet set - can this be passed in as a parameter?
         * Zones:                    $this->zoneName
         * Start Date:               $this->aPeriod['start'] (as PEAR::Date)
         * End Date:                 $this->aPeriod['end'] (as PEAR::Date)
         * Minimum Impression Count: $this->threshold
        **/

        $this->aCampaigns = array();
        $aHeaders = array();

        /*
         * Competing Run-of-Site Campaigns
         * -------------------------------
         * Campaign Name:            $this->aPlacements[$placementId]['placement_name']
         * Campaign Start Date:      $this->aPlacements[$placementId]['placement_start'] (as text)
         * Campaign End Date:        $this->aPlacements[$placementId]['placement_end'] (as text)
         * Zone IDs and Names:       $this->aZoneDetails[$zoneId]['zonename'], or $this->aZoneIds and $this->zoneName when only one zone
         * Booked Impressions:       $this->aExclusivePlacementsRunOfSiteBookings and $this->aHighPriorityPlacementsRunOfSiteBookings
         * Total:                    Implement as XLS Equation, or not shown with only one zone
        **/
        // build totals
        foreach ($this->aExclusivePlacementsRunOfSiteBookings as $campaignId => $campaign) {
            $this->aCampaigns[$campaignId]['total_row'] =
                array(
                'campaign' => '['.$campaignId.'] '.$this->aPlacements[$campaignId]['placement_name'],
                'start_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_start']),
                'end_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_end']),
                'zone' => 'Total',
                'booked_impressions' => 0
            );
        }
        foreach ($this->aHighPriorityPlacementsRunOfSiteBookings as $campaignId => $campaign) {
            $this->aCampaigns[$campaignId]['total_row'] =
                array(
                'campaign' => '['.$campaignId.'] '.$this->aPlacements[$campaignId]['placement_name'],
                'start_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_start']),
                'end_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_end']),
                'zone' => 'Total',
                'booked_impressions' => 0
            );
        }
        // build data rows
        foreach ($this->aExclusivePlacementsRunOfSiteBookings as $campaignId => $campaign) {
            foreach ($campaign as $zoneId => $zone_total) {
                $zone_name = count($this->aZoneDetails) ? '['.$zoneId.'] '.$this->aZoneDetails[$zoneId]['zonename'] : '['.$this->aZoneIds[0].'] '.$this->zoneName;
                $this->aCampaigns[$campaignId]['zone_rows'][$zoneId] =
                    array(
                    'campaign' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'zone' => $zone_name,
                    'booked_impressions' => $zone_total
                );
                $this->aCampaigns[$campaignId]['total_row']['booked_impressions'] += $zone_total;
                // update grand total for this zone
                if (!isset($aZoneTotals[$zoneId]['name'])) { $aZoneTotals[$zoneId]['name'] = $zone_name; }
                $aZoneTotals[$zoneId]['booked_impressions'] += $zone_total;
            }
        }
        foreach ($this->aHighPriorityPlacementsRunOfSiteBookings as $campaignId => $campaign) {
            foreach ($campaign as $zoneId => $zone_total) {
                $zone_name = count($this->aZoneDetails) ? '['.$zoneId.'] '.$this->aZoneDetails[$zoneId]['zonename'] : '['.$this->aZoneIds[0].'] '.$this->zoneName;
                $this->aCampaigns[$campaignId]['zone_rows'][$zoneId] =
                    array(
                    'campaign' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'zone' => $zone_name,
                    'booked_impressions' => $zone_total
                );
                $this->aCampaigns[$campaignId]['total_row']['booked_impressions'] += $zone_total;
                // update grand total for this zone
                if (!isset($aZoneTotals[$zoneId]['name'])) { $aZoneTotals[$zoneId]['name'] = $zone_name; }
                $aZoneTotals[$zoneId]['booked_impressions'] += $zone_total;
            }
        }
        // build output rows
        $data_rows = $this->buildZoneOutputRows();
        // prepare rows for display
        $display_data_1 = $this->prepareAvailableInventoryForDisplay($data_rows);

        /*
         * Competing Campaigns in Channel
         * ------------------------------
         * Campaign Name:            $this->aPlacements[$placementId]['placement_name']
         * Campaign Start Date:      $this->aPlacements[$placementId]['placement_start'] (as text)
         * Campaign End Date:        $this->aPlacements[$placementId]['placement_end'] (as text)
         * Zone IDs and Names:       $this->aZoneDetails[$zoneId]['zonename'], or $this->aZoneIds and $this->zoneName when only one zone
         * Booked Impressions:       $this->aExclusivePlacementsChannelBookings and $this->aHighPriorityPlacementsChannelBookings
         * Total:                    Implement as XLS Equation, or not shown with only one zone
        **/
        $this->aCampaigns = array();
        // build totals
        foreach ($this->aExclusivePlacementsChannelBookings as $campaignId => $campaign) {
            $this->aCampaigns[$campaignId]['total_row'] =
                array(
                'campaign' => '['.$campaignId.'] '.$this->aPlacements[$campaignId]['placement_name'],
                'start_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_start']),
                'end_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_end']),
                'zone' => 'Total',
                'booked_impressions' => 0
            );
        }
        foreach ($this->aHighPriorityPlacementsChannelBookings as $campaignId => $campaign) {
            $this->aCampaigns[$campaignId]['total_row'] =
                array(
                'campaign' => '['.$campaignId.'] '.$this->aPlacements[$campaignId]['placement_name'],
                'start_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_start']),
                'end_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_end']),
                'zone' => 'Total',
                'booked_impressions' => 0
            );
        }
        // build data rows
        foreach ($this->aExclusivePlacementsChannelBookings as $campaignId => $campaign) {
            foreach ($campaign as $zoneId => $zone_total) {
                $zone_name = count($this->aZoneDetails) ? '['.$zoneId.'] '.$this->aZoneDetails[$zoneId]['zonename'] : '['.$this->aZoneIds[0].'] '.$this->zoneName;
                $this->aCampaigns[$campaignId]['zone_rows'][$zoneId] =
                    array(
                    'campaign' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'zone' => $zone_name,
                    'booked_impressions' => $zone_total
                );
                $this->aCampaigns[$campaignId]['total_row']['booked_impressions'] += $zone_total;
                // update grand total for this zone
                if (!isset($aZoneTotals[$zoneId]['name'])) { $aZoneTotals[$zoneId]['name'] = $zone_name; }
                $aZoneTotals[$zoneId]['booked_impressions'] += $zone_total;
            }
        }
        foreach ($this->aHighPriorityPlacementsChannelBookings as $campaignId => $campaign) {
            foreach ($campaign as $zoneId => $zone_total) {
                $zone_name = count($this->aZoneDetails) ? '['.$zoneId.'] '.$this->aZoneDetails[$zoneId]['zonename'] : '['.$this->aZoneIds[0].'] '.$this->zoneName;
                $this->aCampaigns[$campaignId]['zone_rows'][$zoneId] =
                    array(
                    'campaign' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'zone' => $zone_name,
                    'booked_impressions' => $zone_total
                );
                $this->aCampaigns[$campaignId]['total_row']['booked_impressions'] += $zone_total;
                // update grand total for this zone
                if (!isset($aZoneTotals[$zoneId]['name'])) { $aZoneTotals[$zoneId]['name'] = $zone_name; }
                $aZoneTotals[$zoneId]['booked_impressions'] += $zone_total;
            }
        }
        // build output rows
        $data_rows = $this->buildZoneOutputRows();
        // prepare rows for display
        $display_data_2 = $this->prepareAvailableInventoryForDisplay($data_rows);

        /*
         * Competing Campaigns with Overlapping Targeting
         * ----------------------------------------------
         * Campaign Name:            $this->aPlacements[$placementId]['placement_name']
         * Campaign Start Date:      $this->aPlacements[$placementId]['placement_start'] (as text)
         * Campaign End Date:        $this->aPlacements[$placementId]['placement_end'] (as text)
         * Zone IDs and Names:       $this->aZoneDetails[$zoneId]['zonename'], or $this->aZoneIds and $this->zoneName when only one zone
         * Booked Impressions:       $this->aExclusivePlacementsTargetedBookings and $this->aHighPriorityPlacementsTargetedBookings
         * Total:                    Implement as XLS Equation, or not shown with only one zone
        **/
        $this->aCampaigns = array();
        // build totals
        foreach ($this->aExclusivePlacementsTargetedBookings as $campaignId => $campaign) {
            $this->aCampaigns[$campaignId]['total_row'] =
                array(
                'campaign' => '['.$campaignId.'] '.$this->aPlacements[$campaignId]['placement_name'],
                'start_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_start']),
                'end_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_end']),
                'zone' => 'Total',
                'booked_impressions' => 0
            );
        }
        foreach ($this->aHighPriorityPlacementsTargetedBookings as $campaignId => $campaign) {
            $this->aCampaigns[$campaignId]['total_row'] =
                array(
                'campaign' => '['.$campaignId.'] '.$this->aPlacements[$campaignId]['placement_name'],
                'start_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_start']),
                'end_date' => str_replace('0000-00-00', '', $this->aPlacements[$campaignId]['placement_end']),
                'zone' => 'Total',
                'booked_impressions' => 0
            );
        }
        // build data rows
        foreach ($this->aExclusivePlacementsTargetedBookings as $campaignId => $campaign) {
            foreach ($campaign as $zoneId => $zone_total) {
                $zone_name = count($this->aZoneDetails) ? '['.$zoneId.'] '.$this->aZoneDetails[$zoneId]['zonename'] : '['.$this->aZoneIds[0].'] '.$this->zoneName;
                $this->aCampaigns[$campaignId]['zone_rows'][$zoneId] =
                    array(
                    'campaign' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'zone' => $zone_name,
                    'booked_impressions' => $zone_total
                );
                $this->aCampaigns[$campaignId]['total_row']['booked_impressions'] += $zone_total;
                // update grand total for this zone
                if (!isset($aZoneTotals[$zoneId]['name'])) { $aZoneTotals[$zoneId]['name'] = $zone_name; }
                $aZoneTotals[$zoneId]['booked_impressions'] += $zone_total;
            }
        }
        foreach ($this->aHighPriorityPlacementsTargetedBookings as $campaignId => $campaign) {
            foreach ($campaign as $zoneId => $zone_total) {
                $zone_name = count($this->aZoneDetails) ? '['.$zoneId.'] '.$this->aZoneDetails[$zoneId]['zonename'] : '['.$this->aZoneIds[0].'] '.$this->zoneName;
                $this->aCampaigns[$campaignId]['zone_rows'][$zoneId] =
                    array(
                    'campaign' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'zone' => $zone_name,
                    'booked_impressions' => $zone_total
                );
                $this->aCampaigns[$campaignId]['total_row']['booked_impressions'] += $zone_total;
                // update grand total for this zone
                if (!isset($aZoneTotals[$zoneId]['name'])) { $aZoneTotals[$zoneId]['name'] = $zone_name; }
                $aZoneTotals[$zoneId]['booked_impressions'] += $zone_total;
            }
        }
        // build output rows
        $data_rows = $this->buildZoneOutputRows();
        // prepare rows for display
        $display_data_3 = $this->prepareAvailableInventoryForDisplay($data_rows);

        /*
         * Available Inventory
         * -------------------
         * Zone IDs and Names:       $this->aZoneDetails[$zoneId]['zonename'], or $this->aZoneIds and $this->zoneName when only one zone
         * Forecast Impressions:     $this->aChannelForecastsPeriod
         * Booked Impressions:       Implement as XLS Equation
         * Available Impressions:    Implement as XLS Equation
         * Total:                    Implement as XLS Equation, or not shown with only one zone
         *
        **/
        $this->channel_info = Admin_DA::getChannel($this->channelId);
        // build zone totals
        foreach ($aZoneTotals as $zoneId => $zone) {
            $this->aChannel['zone_rows'][$zoneId] =
                array(
                'channel' => '',
                'zone' => $zone['name'],
                'forecast_impressions' => $this->aChannelForecastsPeriod[$zoneId],
                'booked_impressions' => $zone['booked_impressions'],
                'available_impressions' => ($this->aChannelForecastsPeriod[$zoneId] - $zone['booked_impressions'])
            );
            $aGrandTotal['forecast_impressions'] += $this->aChannelForecastsPeriod[$zoneId];
            $aGrandTotal['booked_impressions'] += $zone['booked_impressions'];
        }
        // build grand total
        $this->aChannel['total_row'] =
            array(
            'channel' => '['.$this->channelId.'] '.$this->channel_info['name'],
            'zone' => 'Total',
            'forecast_impressions' => $aGrandTotal['forecast_impressions'],
            'booked_impressions' => $aGrandTotal['booked_impressions'],
            'available_impressions' => ($aGrandTotal['forecast_impressions'] - $aGrandTotal['booked_impressions'])
        );

        // build output rows
        $data_rows = $this->buildChannelOutputRows();
        // prepare rows for display
        $display_data_totals = $this->prepareAvailableInventoryTotalsForDisplay($data_rows);

       /*
        * build headers and data rows
        */
        $block_title = 'Available Inventory';
        $aHeaders = array();
        $display_data_blocks[$block_title] = $display_data_totals;
        $headers = array(
            'Channel' => 'text',
            'Zone' => 'text',
            'Forecast Impressions' => 'number',
            'Booked Impressions' => 'number',
            'Available Impressions' => 'number'
        );
        $aHeaders[$block_title] = $headers;

        $block_title = 'Competing Run-of-Site Campaigns';
        $display_data_blocks[$block_title] = $display_data_1;
        $headers = array(
            'Campaign' => 'text',
            'Start Date' => 'date',
            'End Date' => 'date',
            'Zone' => 'text',
            'Booked Impressions' => 'number'
        );
        $aHeaders[$block_title] = $headers;

        $block_title = 'Competing Campaigns in Channel';
        $display_data_blocks[$block_title] = $display_data_2;
        $headers = array(
            'Campaign' => 'text',
            'Start Date' => 'date',
            'End Date' => 'date',
            'Zone' => 'text',
            'Booked Impressions' => 'number'
        );
        $aHeaders[$block_title] = $headers;

        $block_title = 'Competing Campaigns with Overlapping Targeting';
        $display_data_blocks[$block_title] = $display_data_3;
        $headers = array(
            'Campaign' => 'text',
            'Start Date' => 'date',
            'End Date' => 'date',
            'Zone' => 'text',
            'Booked Impressions' => 'number'
        );
        $aHeaders[$block_title] = $headers;

        // create the worksheet
        $this->createSubReportWithDistinctBlocks('Available Inventory', $aHeaders, $display_data_blocks);
    }


    function buildZoneOutputRows() {
        $data_rows = array();
        $campaign_cnt = count($this->aCampaigns);
        $cnt = 0;
        foreach ($this->aCampaigns as $campaign) {
            $data_rows[] = $campaign['total_row'];
            foreach ($campaign['zone_rows'] as $zone) {
                $data_rows[] = $zone;
            }
            ++$cnt;
            if ($campaign_cnt > 0 && $cnt < $campaign_cnt) { // insert a blank row if required
                $data_rows[] = array('campaign' => '','start_date' => '','end_date' => '','zone' => '','booked_impressions' => '');
            }
        }
        return $data_rows;
    }


    function buildChannelOutputRows() {
        $data_rows = array();
        $data_rows[] = $this->aChannel['total_row'];
        foreach ($this->aChannel['zone_rows'] as $zone) {
            $data_rows[] = $zone;
        }
        return $data_rows;
    }


    /**
     * A private method to prepare the report data, ready to perform the report data generation.
     *
     * @access private
     * @param array $aZoneIds An array containing a SINGLE zone ID, in the event that the
     *                        report is to be limited to a single zone, otherwise an empty
     *                        array.
     * @return boolean True if the raw report data is prepared and ready to be used to generate
     *                 the report data, false otherwise.
     */
    function _prepareRawData($aZoneIds)
    {
        // Obtain all of the required raw data from the database, before performing
        // any data processing in PHP
        $result = $this->_setZones($aZoneIds);
        if (!$result) {
            return false;
        }

        // Obtain the daily inventory forecasts (impressions) for all the channel/zone
        // combinations in the report
        $this->aChannelForecastsDaily =
            $this->oMaxDalStatistcs->getChannelDailyInventoryForecastByChannelZoneIds(
                $this->channelId, $this->aZoneIds, $this->aPeriod, true
            );
        if (PEAR::isError($this->aChannelForecastsDaily)) {
            $this->_setError('Error retrieving channel/zone inventory forecasts.');
            return false;
        }
        if (is_null($this->aChannelForecastsDaily)) {
            $this->_setError('No channel/zone inventory forecast data found.');
            return false;
        }

        // Obtain all of the ads linked to the zones in the report
        $this->aZoneAdIds = $this->oMaxDalEntities->getLinkedActiveAdIdsByZoneIds($this->aZoneIds);
        if (PEAR::isError($this->aZoneAdIds)) {
            $this->_setError('Error retrieving ads linked to zone IDs ' . implode(', ', $this->aZoneIds) . '.');
            return false;
        }
        if (is_null($this->aZoneAdIds)) {
            $this->_setError('No ads found linked to zone IDs ' . implode(', ', $this->aZoneIds) . '.');
            return false;
        }
        $this->aAdIds = array();
        reset($this->aZoneAdIds);
        while (list($zoneId, $aAds) = each($this->aZoneAdIds)) {
            reset($aAds);
            while (list($key, $adId) = each($aAds)) {
                if (!in_array($adId, $this->aAdIds)) {
                    $this->aAdIds[$adId] = $adId;
                }
            }
        }

        // Obtain all of the placements that are parents of these ads, where the placement
        // is expected to be active during the report period, and also obtain all of the ads
        // that are children of these placements -- even if these ads are not linked to the
        // zone(s) of the report -- along with any delivery limitations attached
        $result = $this->_setPlacementAds();
        if (!$result) {
            return false;
        }

        // Obtain all ad/zone links for the located ads
        $this->_setAdZoneLinks();
        if ($this->_error()) {
            return false;
        }

        // Obtain the recent average operation interval inventory forecasts (impressions)
        // for all the zone(s) in the report, as well as any other zones that any ads
        // are linked to
        $aZoneIds = array();
        reset($this->aAdZoneIds);
        while (list($adId, $aZones) = each($this->aAdZoneIds)) {
            reset($aZones);
            while (list($key, $zoneId) = each($aZones)) {
                if (!in_array($zoneId, $aZoneIds)) {
                    $aZoneIds[] = $zoneId;
                }
            }
        }
        $this->aAverageZoneForecasts =
            $this->oMaxDalStatistcs->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        if (PEAR::isError($this->aAverageZoneForecasts)) {
            $this->_setError('Error retrieving zone inventory forecasts.');
            return false;
        }
        if (is_null($this->aAverageZoneForecasts)) {
            $this->_setError('No zone inventory forecast data found.');
            return false;
        }

        // Set the channel limitations
        $result = $this->oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelId($this->channelId);
        if (!$result) {
            $this->_setError('Error setting the overlap limitations for channel ID ' . $this->channelId . '.');
            return false;
        }

        // Set the number of days in the report period
        $oReportPeriodStartDateCopy = new Date($this->aPeriod['start']->format('%Y-%m-%d 00:00:00'));
        $oReportPeriodEndDateCopy = new Date($this->aPeriod['end']->format('%Y-%m-%d 23:59:59'));
        $oReportPeriodEndDateCopy->addSeconds(1);
        $oReportPeriodSpan = new Date_Span();
        $oReportPeriodSpan->setFromDateDiff($oReportPeriodStartDateCopy, $oReportPeriodEndDateCopy);
        $this->reportPeriodDays = $oReportPeriodSpan->toDays();

        return true;
    }

    /**
     * A private method to set the zone(s) that the channel availability report will
     * look into.
     *
     * @access private
     * @param array $aZoneIds An array containing a SINGLE zone ID, in the event that the
     *                        report is to be limited to a single zone, otherwise an empty
     *                        array.
     * @return boolean True on success, false otherwise.
     */
    function _setZones($aZoneIds)
    {
        // Is the report for a specific zone, or for all zones?
        if (empty($aZoneIds)) {
            // Store all the zones that the publisher has
            $this->aZoneIds = $this->oMaxDalEntities->getAllZonesIdsByPublisherId($this->publisherId);
            if (PEAR::isError($this->aZoneIds)) {
                $this->_setError('Error retrieving zones IDs for publisher ID ' . $this->publisherId . '.');
                return false;
            }
            if (is_null($this->aZoneIds)) {
                $this->_setError('Publisher ID ' . $this->publisherId . ' does not have any zones.');
                return false;
            }
            // Store the "name" of the zone(s)
            $this->zoneName = 'All Zones';
            // Get the details of all of the zones
            $this->aZoneDetails = $this->oMaxDalEntities->getZonesByZoneIds($this->aZoneIds);
            if (PEAR::isError($this->aZoneDetails) || is_null($this->aZoneDetails)) {
                $this->_setError('Error retrieving zones details for zone IDs ' . implode(', ', $this->aZoneIds) . '.');
                return false;
            }
        } else {
            // Store the zone
            $this->aZoneIds = $aZoneIds;
            // Store the name of the zone
            $aZoneInfo = $this->oMaxDalEntities->getZonesByZoneIds($aZoneIds);
            if (PEAR::isError($aZoneInfo)) {
                $this->_setError('Error retrieving zone information for zone IDs ' . implode(', ', $aZoneIds) . '.');
                return false;
            }
            if (is_null($aZoneInfo)) {
                $this->_setError('Zone IDs ' . implode(', ', $aZoneIds) . ' had no information.');
                return false;
            }
            $this->zoneName = $aZoneInfo[$aZoneIds[0]]['zonename'];
        }
        return true;
    }

    /**
     * A private method to set the placement and ad information, including delivery limitations,
     * for those placements that are parents of ads linked to the zone(s) in the report, and
     * wherethe placements are active during the report period. The ads are those that are children
     * of these placements, even if they are not linked to the zone(s) in the report.
     *
     * @access private
     * @return boolean True on success, false otherwise.
     */
    function _setPlacementAds()
    {
        // Final the parent placements of the ads
        $this->aPlacements =
            $this->oMaxDalEntities->getAllActivePlacementsByAdIdsPeriod($this->aAdIds, $this->aPeriod);
        if (PEAR::isError($this->aPlacements) || is_null($this->aPlacements)) {
            $this->_setError('Error retrieving parent placements for ads.');
            return false;
        }
        // Prepare an array of the placement IDs found
        $aPlacementIds = array();
        reset($this->aPlacements);
        while (list($adId, $aPlacement) = each($this->aPlacements)) {
            if (!in_array($aPlacement['placement_id'], $aPlacementIds)) {
                $aPlacementIds[] = $aPlacement['placement_id'];
            }
        }
        if (!empty($aPlacementIds)) {
            // Get children ads of the parent placements (including those ads that
            // may not be linked to the zone(s) we are interested in), along with
            // the delivery limitation data for those ads
            $this->aPlacementAds =
                $this->oMaxDalEntities->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacementIds);
            if (PEAR::isError($this->aPlacementAds) || is_null($this->aPlacementAds)) {
                $this->_setError('Error retrieving placement details, ads and delivery limitations.');
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * A private method to obtain and store all ad/zone links for those ads found by the
     * _setPlacementAds() method.
     *
     * @access private
     * @see Plugins_Reports_Publisher_ChannelAvailability::_setPlacementAds()
     * @return boolean True on success, false otherwise.
     */
    function _setAdZoneLinks()
    {
        if (!empty($this->aPlacementAds)) {
            $aAdIds = array();
            reset($this->aPlacementAds);
            while (list($placementId, $aAds) = each($this->aPlacementAds)) {
                reset($aAds);
                while (list($adId, $aAd) = each($aAds)) {
                    if (!in_array($adId, $aAdIds)) {
                        $aAdIds[] = $adId;
                    }
                }
            }
            $this->aAdZoneIds = $this->oMaxDalEntities->getLinkedZonesIdsByAdIds($aAdIds);
            if (PEAR::isError($this->aAdZoneIds) || is_null($this->aAdZoneIds)) {
                $this->_setError('Error retrieving ad/zone links.');
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * A private method to convert the stored daily channel/zone inventory impression
     * forecasts into channel/zone inventory impression forecasts for the report period,
     * and store these values.
     *
     * @access private
     */
    function _setChannelZoneInventoryForecasts()
    {
        $this->aChannelForecastsPeriod = array();
        reset($this->aChannelForecastsDaily);
        while (list($zoneId, $aDailyData) = each($this->aChannelForecastsDaily)) {
            if (is_null($this->aChannelForecastsPeriod[$zoneId])) {
                $this->aChannelForecastsPeriod[$zoneId] = 0;
            }
            reset($aDailyData);
            while (list($date, $forecast) = each($aDailyData)) {
                $this->aChannelForecastsPeriod[$zoneId] += $forecast;
            }
            if ($this->aChannelForecastsPeriod[$zoneId] < $this->threshold) {
                unset($this->aChannelForecastsPeriod[$zoneId]);
            }
        }
        if (empty($this->aChannelForecastsPeriod[$zoneId])) {
            unset($this->aChannelForecastsPeriod[$zoneId]);
        }
    }

    /**
     * A private method to convert the stored recent average zone inventory impression
     * forecasts into zone inventory impression forecasts for the report period,
     * and store these values.
     *
     * @access private
     */
    function _setZoneInventoryForecasts()
    {
        $operationIntervals = $this->reportPeriodDays * MAX_OperationInterval::operationIntervalsPerDay();
        $this->aZoneForecastsPeriod = array();
        reset($this->aAverageZoneForecasts);
        while (list($zoneId, $averageImpressions) = each($this->aAverageZoneForecasts)) {
            $this->aZoneForecastsPeriod[$zoneId] = $operationIntervals * $averageImpressions;
        }
    }

    /**
     * A private method to calculate the booked inventory in the channel/zone(s)
     * resulting from exclusive and high-priority placements.
     *
     * @access private
     */
    function _setBookedInventory()
    {
        $this->aBookingInfo = array();
        // Examine the placements active in the report period
        reset($this->aPlacements);
        while (list($key, $aPlacement) = each($this->aPlacements)) {
            // Is the placement an exclusive or high-priority placement?
            if ($aPlacement['priority'] == 0) {
                // No, it's low priority - ignore
                continue;
            }
            // Does the placement run longer than the report period?
            $this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['runFraction']
                = $this->_getPlacementRunFraction($aPlacement);
            // Create a MAX_Entity_Placement object of the exclusive placement
            $oPlacement = new MAX_Entity_Placement($aPlacement);
            // Does this placement have total lifetime inventory requirements,
            // daily inventory requirements, or neither (ie unlimited)? Note
            // that the daily inventory requirements should only be tested for
            // high-priority placements, as exclusive placements cannot have
            // daily inventory requirements!
            $totalRequirements = false;
            $dailyRequirements = false;
            if ($oPlacement->impressionTargetTotal != -1 || $oPlacement->clickTargetTotal != -1 || $oPlacement->conversionTargetTotal != -1) {
                $totalRequirements = true;
            }
            if (($aPlacement['priority'] > 0) && ($oPlacement->impressionTargetDaily != -1 || $oPlacement->clickTargetDaily != -1 || $oPlacement->conversionTargetDaily != -1)) {
                $dailyRequirements = true;
            }
            if (!$totalRequirements && !$dailyRequirements) {
                // The placement is an unlimited placement, so book unlimited impressions
                $this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['impressions'] = -1;
            } else if ($totalRequirements) {
                // The placement has total lifetime inventory requirements, so convert
                // any click or conversion targets it may have into impression targets,
                // and pick the required impression target from any resulting values,
                // ignoring any past delivery data, as we are interested in the booked
                // values, not the future delivery values
                $oGetRequiredAdImpressions = new MAX_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions();
                $oGetRequiredAdImpressions->getPlacementImpressionInventoryRequirement($oPlacement, 'total', true);
                // Reduce the total impression inventory requirement for the placement if
                // the placement runs for more days than the report period
                $this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['impressions'] =
                    $oPlacement->requiredImpressions *
                    $this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['runFraction'];
            } else if ($dailyRequirements) {
                // The placement has daily inventory requirements, so convert any daily
                // click or conversion targets it may have into daily impression targets,
                // and pick the required daily impression target from any resulting values,
                // ignoring any past delivery data, as we are interested in the booked
                // values, not the future delivery values
                $oGetRequiredAdImpressions = new MAX_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions();
                $oGetRequiredAdImpressions->getPlacementImpressionInventoryRequirement($oPlacement, 'daily', true);
                // Increase the daily impression inventory requirement for the placement to
                // cover the number of days in the report period
                $this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['impressions'] =
                    $oPlacement->requiredImpressions * $this->reportPeriodDays;
            }
            // Get the sum of the ad weights in the placement
            $adWeightSum = $this->_getAdWeightSum($this->aPlacementAds[$aPlacement['placement_id']]);
            // Split the placement's impression inventory between the children ad(s)
            reset($this->aPlacementAds[$aPlacement['placement_id']]);
            while (list($adId, $aAd) = each($this->aPlacementAds[$aPlacement['placement_id']])) {
                if ($adWeightSum != 0) {
                    if ($this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['impressions'] == -1) {
                        $this->aBookingInfo[$aPlacement['placement_id']]['adBooked'][$adId]['impressions'] = -1;
                    } else {
                        $this->aBookingInfo[$aPlacement['placement_id']]['adBooked'][$adId]['impressions'] = round(
                            $this->aBookingInfo[$aPlacement['placement_id']]['placementBooked']['impressions'] * $aAd['weight'] / $adWeightSum
                        );
                    }
                }
            }
        }
        // For every ad in an exclusive placement that has had a set number of impressions
        // booked (as opposed to an unlimited number of impressions booked), allocate these
        // impressions to the ad's linked zones, and store these booked impressions where
        // they will appear in the report channel, and the zone is in this report
        $this->_bookLimitedAds('exclusive');
        // For every ad in an exclusive placement that has had an unlimited number of
        // impressions booked, allocate any remaining impressions that exist in the ad's
        // linked zones, and store these booked impressions where they will appear in the
        // report channel, and the zone is in this report
        $this->_bookUnlimitedExclusiveAds();
        // For every ad in a high-priority placement that has had a set number of impressions
        // booked (as opposed to an unlimited number of impressions booked), allocate these
        // impressions to the ad's linked zones, and store these booked impressions where
        // they will appear in the report channel, and the zone is in this report
        $this->_bookLimitedAds('high-priority');
    }

    /**
     * A private method to determine if an placement runs for longer than the
     * report period, and if so, the fraction of the booked inventory that falls
     * within the report period, assuming even delivery over time.
     *
     * @access private
     * @param array $aPlacement An array containing the placement details, specifically,
     *                          'placement_id', being the placement ID, and 'placement_start'
     *                          and 'placement_end', being text-based representations of the
     *                          placement start and end dates.
     * @return integer A value to adjust the placement's booked inventory by, in the event
     *                 that the placement runs longer than the report period; 1 otherwise.
     *
     * @TODO Should be updated so that, if no end date is set, and there is an inventory
     *       requirement, the "end date" is predicted from the inventory requirement and
     *       the past delivery history. See trac ticket #969.
     */
    function _getPlacementRunFraction($aPlacement)
    {
        $startsBeforePeriod = true;
        $endsAfterPeriod    = true;
        // Get the details on when the placement starts and ends
        if (is_null($aPlacement['placement_start']) || ($aPlacement['placement_start'] == '0000-00-00')) {
            // Need to calculate when then placement actually started; DAL method returns
            // the date of the placement's first impression, of, if there are none, assumes
            // that the placement is brand new, and will start NOW
            $oPlacementStartDate = $this->oMaxDalStatistcs->getPlacementFirstStatsDate($aPlacement['placement_id']);
        } else {
            $oPlacementStartDate = new Date($aPlacement['placement_start']);
        }
        if (!$oPlacementStartDate->before($this->aPeriod['start'])) {
            $startsBeforePeriod = false;
        }
        if (is_null($aPlacement['placement_end']) || ($aPlacement['placement_end'] == '0000-00-00')) {
            // The placement has no actual end date, so assume placement ends when the report
            // ends (ie. assume all booked inventory will deliver as fast as possible, and#
            // the worst case is that it will all happen during the report period)
            $oPlacementEndDate = new Date($this->aPeriod['end']->format('%Y-%m-%d'));
        } else {
            $oPlacementEndDate = new Date($aPlacement['placement_end']);
        }
        if (!$oPlacementEndDate->after($this->aPeriod['end'])) {
            $endsAfterPeriod = false;
        }
        // Doe the placement run entirely within the report period?
        if ($startsBeforePeriod || $endsAfterPeriod) {
            // No, the placement runs at some period outside than the report period, so the
            // booked inventory values must be changed to deal with this fact; Assume even
            // delivery per day over the course of the placement's run
            $oPlacementStartDateCopy = new Date($oPlacementStartDate->format('%Y-%m-%d 00:00:00'));
            $oPlacementEndDateCopy = new Date($oPlacementEndDate->format('%Y-%m-%d 23:59:59'));
            $oPlacementEndDateCopy->addSeconds(1);
            $oPlacementSpan = new Date_Span();
            $oPlacementSpan->setFromDateDiff($oPlacementStartDateCopy, $oPlacementEndDateCopy);
            if ($startsBeforePeriod) {
                $oPlacementInPeriodStartDateCopy = new Date($this->aPeriod['start']->format('%Y-%m-%d 00:00:00'));
            } else {
                $oPlacementInPeriodStartDateCopy = new Date($oPlacementStartDate->format('%Y-%m-%d 00:00:00'));
            }
            if ($endsAfterPeriod) {
                $oPlacementInPeriodEndDateCopy = new Date($this->aPeriod['end']->format('%Y-%m-%d 23:59:59'));
            } else {
                $oPlacementInPeriodEndDateCopy = new Date($oPlacementEndDate->format('%Y-%m-%d 23:59:59'));
            }
            $oPlacementInPeriodEndDateCopy->addSeconds(1);
            $oPlacementInPeriodSpan = new Date_Span();
            $oPlacementInPeriodSpan->setFromDateDiff($oPlacementInPeriodStartDateCopy, $oPlacementInPeriodEndDateCopy);
            return $oPlacementInPeriodSpan->toDays() / $oPlacementSpan->toDays();
        }
        return 1;
    }

    /**
     * A private method to calculate the sum of the ad weights in an array of ads.
     *
     * @access private
     * @param array $aAds An array of arrays, indexed by ad ID, containing at least
     *                    the ad weights in the 'weight' index.
     * @return integer The sum of the ad weights.
     */
    function _getAdWeightSum($aAds)
    {
        $weight = 0;
        reset($aAds);
        while (list($adId, $aAd) = each($aAds)) {
            $weight += $aAd['weight'];
        }
        return $weight;
    }

    /**
     * A private method to look at any booked impression inventory allocated to ads in
     * exclusive or high-priority placements, and distribute the booked impression inventory
     * between the zones the ads are linked to, as required.
     *
     * Only works with ads that do NOT have unlimited impression inventory booked.
     *
     * Only stores results for those zones that are in the report.
     *
     * @access private
     * @param string $placementType The placement type, either "exclusive" or "high-priority".
     *
     * @TODO Incomplete implementation, as does not have access to required
     *       channel summarisation data to predict the level of overlap. See
     *       trac.openads.org tickets #956, #957.
     */
    function _bookLimitedAds($placementType)
    {
        reset($this->aBookingInfo);
        while (list($placementId, $aPlacementBookingInfo) = each($this->aBookingInfo)) {
            // Is this placement an exclusive  or high-priority placement?
            if (($placementType == 'exclusive' && $this->aPlacements[$placementId]['priority'] != -1) ||
                ($placementType == 'high-priority' && $this->aPlacements[$placementId]['priority'] < 1)) {
                continue;
            }
            reset($aPlacementBookingInfo['adBooked']);
            while (list($adId, $aBookedInfo) = each($aPlacementBookingInfo['adBooked'])) {
                // Does the ad actually have any non-unlimited impressions that can
                // be allocated to its linked zones?
                if ($aBookedInfo['impressions'] == 0 || $aBookedInfo['impressions'] == -1) {
                    continue;
                }
                // Determine if the ad's targeting is: No delivery limitations, matching
                // the channel, overlapping with the channel, or none of these
                $type = $this->_getAdLimitationType($placementId, $adId);
                if (empty($type)) {
                    // The delivery limitations do not overlap, so the ad's booked
                    // impressions will not appear in this report
                    continue;
                }
                // Set the array to book these impressions into based on the type of delivery
                // limitation the ad has
                if ($placementType == 'exclusive' && $type == 'none') {
                    $aStore = &$this->aExclusivePlacementsRunOfSiteBookings;
                } else if ($placementType == 'exclusive' && $type == 'matches') {
                    $aStore = &$this->aExclusivePlacementsChannelBookings;
                } else if ($placementType == 'exclusive' && $type == 'overlap') {
                    $aStore = &$this->aExclusivePlacementsTargetedBookings;
                } else if ($placementType == 'high-priority' && $type == 'none') {
                    $aStore = &$this->aHighPriorityPlacementsRunOfSiteBookings;
                } else if ($placementType == 'high-priority' && $type == 'matches') {
                    $aStore = &$this->aHighPriorityPlacementsChannelBookings;
                } else if ($placementType == 'high-priority' && $type == 'overlap') {
                    $aStore = &$this->aHighPriorityPlacementsTargetedBookings;
                }
                // This ad may be linked to a set of zones that is completely different to other ads,
                // so calculate the sum of the recent average zone inventory forecast values for those
                // zones that THIS ad is linked to
                $zoneForecastSum = 0;
                $aZoneForecastValues = array();
                reset($this->aAdZoneIds[$adId]);
                while (list($key, $zoneId) = each($this->aAdZoneIds[$adId])) {
                    if (!is_null($this->aAverageZoneForecasts[$zoneId])) {
                        $zoneForecastSum += $this->aAverageZoneForecasts[$zoneId];
                        $aZoneForecastValues[$zoneId] = $this->aAverageZoneForecasts[$zoneId];
                    }
                }
                // If the zone forecast sum is zero, assume even delivery between the zones that THIS
                // ad is linked to
                if ($zoneForecastSum == 0) {
                    reset($this->aAdZoneIds[$adId]);
                    while (list($key, $zoneId) = each($this->aAdZoneIds[$adId])) {
                        $aZoneForecastValues[$zoneId] = 1;
                    }
                    $zoneForecastSum = count($aZoneForecastValues);
                }
                // Now that the required zone forecast sum information has been calculated for all the
                // zones that THIS ad is linked to, allocate the ad's impressions between the zones
                reset($this->aAdZoneIds[$adId]);
                while (list($key, $zoneId) = each($this->aAdZoneIds[$adId])) {
                    // Only store the ad/zone allocation if the zone part of the report
                    if (in_array($zoneId, $this->aZoneIds)) {
                        // If a new placement/zone, set the booked inventory to zero
                        if (is_null($aStore[$placementId][$zoneId])) {
                            $aStore[$placementId][$zoneId] = 0;
                        }
                        // Calculate the ad's impressions in the zone based on the relative zone forecasts
                        $adImpressionsInZone =
                            round($aBookedInfo['impressions'] * $aZoneForecastValues[$zoneId] / $zoneForecastSum);
                        if ($type == 'none') {
                            // As the ad is not targeted, adjust the number of impressions that will
                            // appear in the channel based on the relative channel/zone forecasts
                            if (!is_null($this->aChannelForecastsPeriod[$zoneId]) &&
                                !is_null($this->aZoneForecastsPeriod[$zoneId]) &&
                                ($this->aZoneForecastsPeriod[$zoneId] > $this->aChannelForecastsPeriod[$zoneId])) {
                                $adImpressionsInZone =
                                    round($adImpressionsInZone * $this->aChannelForecastsPeriod[$zoneId]
                                        / $this->aZoneForecastsPeriod[$zoneId]);
                            }
                        } else if ($type == 'overlap') {
                            // As the ad's tartgeting overlaps with the channel, adjust the number of
                            // impressions that will appear in the channel based on past information,
                            // when possible - otherwise, assume 100% overlap

                            /*
                             * Code in here, please!
                             */

                        }
                        $aStore[$placementId][$zoneId] += $adImpressionsInZone;
                    }
                }
            }
        }
    }

    /**
     * A private method to booked inventory in the report channel/zone(s) from
     * ads that are in an exclusive placements, where those ads have unlimited
     * inventory booked.
     *
     * Only stores results for those zones that are in the report.
     *
     * @access private
     *
     * @TODO Incomplete implementation, as does not have access to required
     *       channel summarisation data to predict the level of overlap. See
     *       trac.openads.org tickets #956, #957.
     */
    function _bookUnlimitedExclusiveAds()
    {
        // Prepare the placement * ad weight values for all ads in exclusive placements
        // that have unlimited inventory booked
        reset($this->aBookingInfo);
        while (list($placementId, $aPlacementBookingInfo) = each($this->aBookingInfo)) {
            // Is this placement an exclusive placement?
            if ($this->aPlacements[$placementId]['priority'] != -1) {
                continue;
            }
            reset($aPlacementBookingInfo['adBooked']);
            while (list($adId, $aBookedInfo) = each($aPlacementBookingInfo['adBooked'])) {
                // Does the ad actually have an unlimited impression booking?
                if ($aBookedInfo['impressions'] != -1) {
                    continue;
                }
                $this->_setPlacementAdWeight($placementId, $adId);
            }
        }
        // Prepare an array of the remaining unbooked inventory in each zone at this point
        // in the allocation process (ie. after non-unlimited exclusive ads are booked, but
        // before non-unlimited high-priority ads are booked)
        $aRemainingZoneInventory = array();
        reset($this->aChannelForecastsPeriod);
        while (list($zoneId, $forecast) = each($this->aChannelForecastsPeriod)) {
            $aRemainingZoneInventory[$zoneId] = $forecast;
        }
        $aBookedZoneInventory = array();
        $this->_getBookedZoneInventory($aBookedZoneInventory);
        reset($aBookedZoneInventory);
        while (list($zoneId, $booked) = each($aBookedZoneInventory)) {
            if (!is_null($aRemainingZoneInventory[$zoneId])) {
                if (!is_null($aBookedZoneInventory[$zoneId])) {
                    $aRemainingZoneInventory[$zoneId] -= $booked;
                }
            }
        }
        // Prepare array to temporarily store exclusive unlimited ad booked inventory
        // (as it cannot be directly stored, as values may need to be re-evaulated
        // should additional ads be linked to the same zones later)
        $aZonesContributingAds = array();
        $aExclusivePlacementsRunOfSiteBookings = array();
        $aExclusivePlacementsChannelBookings   = array();
        $aExclusivePlacementsTargetedBookings  = array();
        // Book in the unlimited exclusive ad inventory
        reset($this->aBookingInfo);
        while (list($placementId, $aPlacementBookingInfo) = each($this->aBookingInfo)) {
            // Is this placement an exclusive placement?
            if ($this->aPlacements[$placementId]['priority'] != -1) {
                continue;
            }
            reset($aPlacementBookingInfo['adBooked']);
            while (list($adId, $aBookedInfo) = each($aPlacementBookingInfo['adBooked'])) {
                // Does the ad actually have an unlimited impression booking?
                if ($aBookedInfo['impressions'] != -1) {
                    continue;
                }
                // Determine if the ad's targeting is: No delivery limitations, matching
                // the channel, overlapping with the channel, or none of these
                $type = $this->_getAdLimitationType($placementId, $adId);
                if (empty($type)) {
                    // The delivery limitations do not overlap, so the ad's booked
                    // impressions will not appear in this report
                    continue;
                }
                // For each zone that THIS ad is linked to...
                reset($this->aAdZoneIds[$adId]);
                while (list($key, $zoneId) = each($this->aAdZoneIds[$adId])) {
                    // If the zone is one that is in the report...
                    if (in_array($zoneId, $this->aZoneIds)) {
                        // Record that this zone now has this ad ID booking in remaining inventory
                        $aZonesContributingAds[$zoneId][$adId] = array(
                            'weight'       => $this->aBookingInfo[$placementId]['adBooked'][$adId]['weight'],
                            'placement_id' => $placementId,
                            'type'         => $type
                        );
                        // Get the sum of the weights of the contributing ads
                        $adWeightSum = $this->_getAdWeightSum($aZonesContributingAds[$zoneId]);
                        // Now, distribute the remaining inventory in the zone between the
                        // constituent ads that are linked to this zone, so that the inventory
                        // is allocated proportional to the placement * ad weight values
                        reset($aZonesContributingAds[$zoneId]);
                        while (list($newAdId, $aNewAdData) = each($aZonesContributingAds[$zoneId])) {
                            // Calculate the ad's share of the remaining inventory
                            $adImpressionsInZone = $aRemainingZoneInventory[$zoneId] * $aNewAdData['weight'] / $adWeightSum;
                            // Adjust the value for the fraction the ad will be active
                            $adImpressionsInZone *=
                                $this->aBookingInfo[$aNewAdData['placement_id']]['placementBooked']['runFraction'];
                            // Store the booked impressions
                            if ($aNewAdData['type'] == 'none') {
                                $aExclusivePlacementsRunOfSiteBookings[$aNewAdData['placement_id']][$zoneId][$newAdId] =
                                    round($adImpressionsInZone);
                            } else if ($aNewAdData['type'] == 'matches') {
                                $aExclusivePlacementsChannelBookings[$aNewAdData['placement_id']][$zoneId][$newAdId] =
                                    round($adImpressionsInZone);
                            } else if ($aNewAdData['type'] == 'overlap') {
                                $aExclusivePlacementsTargetedBookings[$aNewAdData['placement_id']][$zoneId][$newAdId] =
                                    round($adImpressionsInZone);
                            }
                        }
                    }
                }
            }
        }
        // Assign the booked up inventory, now that it has been calculated, to the final arrays
        $this->_storeUnlimitedExclusive($aExclusivePlacementsRunOfSiteBookings, 'ROS');
        $this->_storeUnlimitedExclusive($aExclusivePlacementsChannelBookings, 'Channel');
        $this->_storeUnlimitedExclusive($aExclusivePlacementsTargetedBookings, 'Targeted');
    }

    /**
     * A private method to determine if an ad has delivery limitations, and if so,
     * if they match the channel in the report, overlap with the channel in the
     * report, or neither.
     *
     * @access private
     * @param integer $placementId
     * @param integer $adId
     * @return string The string "none" if the ad has no delivery limitations,
     *                "matches" if the delivery limtiations match the channel in
     *                the report, "overlap" if the delivery limitations overlap
     *                the channel in the report, or an empty string in the case
     *                of an error, or if the ad's delivery limitations do not
     *                overlap with the channel in the report.
     */
    function _getAdLimitationType($placementId, $adId)
    {
        // Does the ad have delivery limitations?
        if (empty($this->aPlacementAds[$placementId][$adId]['deliveryLimitations'])) {
            return 'none';
        }
        // Prepare the local instance of the MAX_Plugin_DeliveryLimitations_MatchOverlap
        // class with the delivery limitations of the ad
        $result = $this->oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByAdArray(
            $this->aPlacementAds[$placementId][$adId]['deliveryLimitations']
        );
        if (!$result) {
            // Error!
            return '';
        }
        // Do the ad delivery limitations match the channel?
        if ($this->oMaxPluginDeliveryLimitationsMatchOverlap->match()) {
            return 'matches';
        }
        // Do the ad delivery limitations overlap with the channel?
        if ($this->oMaxPluginDeliveryLimitationsMatchOverlap->overlap()) {
            return 'overlap';
        }
        // There is no overlap
        return '';
    }

    /**
     * A private method to calculate and store the placement * ad weight for
     * ads that have unlimited inventory booked. Stores the weight in
     * $this->aBookingInfo[$placementId]['adBooked'][$adId]['weight'].
     *
     * @access private
     * @param integer $placementId The placement ID.
     * @param integer $adId The ad ID.
     */
    function _setPlacementAdWeight($placementId, $adId)
    {
        // Does the ad have any unlimited levels of booked inventory?
        if ($this->aBookingInfo[$placementId]['adBooked'][$adId]['impressions'] == -1) {
            $this->aBookingInfo[$placementId]['adBooked'][$adId]['weight'] =
                $this->aPlacements[$placementId]['weight'] * $this->aPlacementAds[$placementId][$adId]['weight'];
            if (is_null($this->aBookingInfo[$placementId]['adBooked'][$adId]['weight']) ||
                $this->aBookingInfo[$placementId]['adBooked'][$adId]['weight'] == 0) {
                $this->aBookingInfo[$placementId]['adBooked'][$adId]['weight'] = 1;
            }
            // No need to calculate the value again if the ad has more
            // than one type of unlimited booked inventory
            return;
        }
    }

    /**
     * A private method to sum the inventory already booked up in zones in the report.
     *
     * @access private
     * @param array $aBookedZoneInventory A reference to the array to store the booked
     *                                    inventory in, indexed by zone ID.
     */
    function _getBookedZoneInventory(&$aBookedZoneInventory)
    {
        $aExclusiveArrays = array(
            &$this->aExclusivePlacementsRunOfSiteBookings,
            &$this->aExclusivePlacementsChannelBookings,
            &$this->aExclusivePlacementsTargetedBookings
        );
        reset($aExclusiveArrays);
        while (list($key, $aArray) = each($aExclusiveArrays)) {
            reset($aArray);
            while (list($placementId, $aPlacementBookings) = each($aArray)) {
                reset($aPlacementBookings);
                while (list($zoneId, $booking) = each($aPlacementBookings)) {
                    if (is_null($aBookedZoneInventory[$zoneId])) {
                        $aBookedZoneInventory[$zoneId] = 0;
                    }
                    $aBookedZoneInventory[$zoneId] += $booking;
                }
            }
        }
    }

    /**
     * A private method to store exclusive placement inventory bookings resulting from
     * ads with unlimited inventory bookings into the final report arrays.
     *
     * @access private
     * @param array $aData A reference to an array containing the booked inventory
     *                     that has come from ads with unlimited booked inventory,
     *                     indexed by placement ID and zone ID.
     * @param string $type One of "ROS", "Channel" or "Targeted".
     */
    function _storeUnlimitedExclusive(&$aData, $type)
    {
        // Set the array to store data in
        if ($type == 'ROS') {
            $aStore = &$this->aExclusivePlacementsRunOfSiteBookings;
        } else if ($type == 'Channel') {
            $aStore = &$this->aExclusivePlacementsChannelBookings;
        } else if ($type == 'Targeted') {
            $aStore = &$this->aExclusivePlacementsTargetedBookings;
        }
        // Store the data
        reset($aData);
        while (list($placementId, $aPlacementData) = each($aData)) {
            reset($aPlacementData);
            while (list($zoneId, $aZoneData) = each($aPlacementData)) {
                reset($aZoneData);
                while (list($adId, $booked) = each($aZoneData)) {
                    if (!is_null($booked)) {
                        if (is_null($aStore[$placementId][$zoneId])) {
                            $aStore[$placementId][$zoneId] = 0;
                        }
                        $aStore[$placementId][$zoneId] += $booked;
                    }
                }
            }
        }
    }

    /**
     * A private method to set an error message to display to the user in the event
     * that the report cannot be generated.
     *
     * @access private
     * @param string $message The error message to set.
     */
    function _setError($message)
    {
        if (!$this->_error()) {
            $this->error = $message;
        }
    }

    /**
     * A private method to determine if the report is in error condition, or not.
     *
     * @access private
     * @return boolean True when there is an error, false otherwise.
     */
    function _error()
    {
        if (!empty($this->error)) {
            return true;
        }
        return false;
    }

}

?>
