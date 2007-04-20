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
$Id$
*/

/**
 * Report base class for Openads
 *
 * @todo Pull up common methods into this class
 *
 * @since 0.3.19 - Feb 28, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id$
 */

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reportWriter/output/NullReportWriter.plugin.php';
require_once MAX_PATH . '/plugins/reports/proprietary/ProprietaryReportingDal.php';

class EnhancedReport extends Plugins_Reports
{
    var $_name;
    var $_description;
    var $_category;
    var $_categoryName;
    var $_author;
    var $_export;
    var $_authorize;
    var $_import;

    /* @var ExcelReportWriter */
    var $_report_writer;
    
    /* @var MAX_Dal_Proprietary */
    var $dal;

    /**
     * PHP4-style Constructor
     */
    function EnhancedReport()
    {
        $this->_export = 'xls';
        $this->_useDefaultDal();
        $this->_report_writer = new Plugins_ReportWriter_Output_NullReportWriter();
    }

    /**
     * Fill a new worksheet with tabular data.
     *
     * @param string $title Name of the worksheet and title of the sub-report
     * @param array $headers Column headings
     * @param array $data Actual data (with no headings)
     *
     * @todo Replace createReportWorksheet() etc with calls to the report writer
     */
    function createSubReport($worksheet, $headers, $data, $title = '')
    {
        if ($title == '') {
            $title = $worksheet;
        }

        $this->_report_writer->createReportWorksheet($worksheet, $this->_name, $this->getReportParametersForDisplay());
        $this->_report_writer->createReportSection($worksheet, $title, $headers, $data, 30);
    }

    /**
     * @todo Eliminate code duplication with createSubReport()
     */
    function createSubReportWithBlocks($worksheet, $headers, $data_blocks, $title = '')
    {
        $this->_report_writer->createReportWorksheet($worksheet, $this->_name, $this->getReportParametersForDisplay());
        foreach ($data_blocks as $section_title => $data) {
            $this->_report_writer->createReportSection($worksheet, $section_title, $headers, $data, 30);
        }
    }

    function createSubReportWithDistinctBlocks($worksheet, $headers, $data_blocks, $title = '')
    {
        $this->_report_writer->createReportWorksheet($worksheet, $this->_name, $this->getReportParametersForDisplay());
        foreach ($data_blocks as $section_title => $data) {
            $this->_report_writer->createReportSection($worksheet, $section_title, $headers[key($data_blocks)], $data, 30);
            next($data_blocks);
        }
    }

    function getReportParametersForDisplay()
    {
        return array(MAX_Plugin_Translation::translate('Report on', $this->module, $this->package) => MAX_Plugin_Translation::translate('All available data', $this->module, $this->package));
    }
    
    function _useDefaultDal()
    {
        $oServiceLocator = ServiceLocator::instance();
        $dal =& $oServiceLocator->get('MAX_Dal_Reporting_Proprietary');
        if (!$dal) {
            $dal = new MAX_Dal_Reporting_Proprietary();
        }
        $this->dal =& $dal;
    }
    
        
    /**
     * @todo Consider where to put Excel bits (if anywhere)
     * @todo See if this can be used for all views/clicks/CTR displays
     * @todo Consider moving this method
     */
    function prepareZoneEffectivenessForDisplay($zones_data)
    {
        $displayable_data = array();
        foreach($zones_data as $zone)
        {
            $displayable_zone = array();
            
            $ctr = $this->calculateClickthroughRatioForDisplay($zone, 'zone_');
            
            $campaign = Admin_DA::getPlacement($this->_campaign_id);
            $campaign['anonymous'] == 't' ? $campaignAnonymous = true : $campaignAnonymous = false;
            $displayable_name = MAX_getZoneName($zone['zone_name'], null, $campaignAnonymous, $zone['zone_id']);
            
            $width = $zone['zone_width'];
            $height = $zone['zone_height'];
            $displayable_size = $width . 'x' . $height;
            
            $displayable_zone[] = $displayable_name;
            $displayable_zone[] = $displayable_size;
            $displayable_zone[] = $zone['zone_impressions'];
            $displayable_zone[] = $zone['zone_clicks'];
            $displayable_zone[] = $ctr;
            
            $displayable_data[] = $displayable_zone; 
        }
        return $displayable_data;
    }
        
    /**
     * @todo Consider where to put Excel formula (if anywhere)
     */
    function prepareDailyEffectivenessForDisplay($days)
    {
        $days_display = array();
        foreach ($days as $day) {
            $ctr = $this->calculateClickthroughRatioForDisplay($day);
            $days_display[] = array(
                $day['day'],
                $day['impressions'],
                $day['clicks'],
                $ctr
            );
        }
        return $days_display;
    }

    function prepareAvailableInventoryForDisplay($data_rows)
    {
        $display_data = array();
        foreach ($data_rows as $row) {
            $display_data[] = array(
                $row['campaign'],
                $row['start_date'],
                $row['end_date'],
                $row['zone'],
                $row['booked_impressions']
            );
        }
        return $display_data;
    }

    function prepareAvailableInventoryTotalsForDisplay($data_rows)
    {
        $display_data = array();
        foreach ($data_rows as $row) {
            $display_data[] = array(
                $row['channel'],
                $row['zone'],
                $row['forecast_impressions'],
                $row['booked_impressions'],
                $row['available_impressions']
            );
        }
        return $display_data;
    }
   
    function prepareDailyDomainPageEffectivenessForDisplay($days)
    {
        $days_display = array();
        foreach ($days as $day) {
            $ctr = $this->calculateClickthroughRatioForDisplay($day);
            $days_display[] = array(
                $day['day'],
                $day['domain'],
                $day['page'],
                $day['impressions'],
                $day['clicks'],
                $ctr
            );
        }
        return $days_display;
    }
    
    function prepareDailyCountryEffectivenessForDisplay($days)
    {
        $days_display = array();
        foreach ($days as $day) {
            $ctr = $this->calculateClickthroughRatioForDisplay($day);
            $days_display[] = array(
                $day['day'],
                $day['country'],
                $day['impressions'],
                $day['clicks'],
                $ctr
            );
        }
        return $days_display;
    }
    
    function prepareDailySourceEffectivenessForDisplay($days)
    {
        $days_display = array();
        foreach ($days as $day) {
            $ctr = $this->calculateClickthroughRatioForDisplay($day);
            $days_display[] = array(
                $day['day'],
                $day['source'],
                $day['impressions'],
                $day['clicks'],
                $ctr
            );
        }
        return $days_display;
    }

    function prepareDailySiteKeywordEffectivenessForDisplay($days)
    {
        $days_display = array();
        foreach ($days as $day) {
            $ctr = $this->calculateClickthroughRatioForDisplay($day);
            $days_display[] = array(
                $day['day'],
                $day['site'],
                $day['keyword'],
                $day['impressions'],
                $day['clicks'],
                $ctr
            );
        }
        return $days_display;
    }

   function prepareMonthlyDomainPageEffectivenessForDisplay($months)
    {
        $months_display = array();
        foreach ($months as $month) {
            $ctr = $this->calculateClickthroughRatioForDisplay($month);
            $months_display[] = array(
                substr($month['yearmonth'], 0, 4).'-'.substr($month['yearmonth'], 4, 2),
                $month['domain'],
                $month['page'],
                $month['impressions'],
                $month['clicks'],
                $ctr
            );
        }
        return $months_display;
    }
    
   function prepareMonthlyCountryEffectivenessForDisplay($months)
    {
        $months_display = array();
        foreach ($months as $month) {
            $ctr = $this->calculateClickthroughRatioForDisplay($month);
            $months_display[] = array(
                substr($month['yearmonth'], 0, 4).'-'.substr($month['yearmonth'], 4, 2),
                $month['country'],
                $month['impressions'],
                $month['clicks'],
                $ctr
            );
        }
        return $months_display;
    }
    
    function prepareMonthlySourceEffectivenessForDisplay($months)
    {
        $months_display = array();
        foreach ($months as $month) {
            $ctr = $this->calculateClickthroughRatioForDisplay($month);
            $months_display[] = array(
                substr($month['yearmonth'], 0, 4).'-'.substr($month['yearmonth'], 4, 2),
                $month['source'],
                $month['impressions'],
                $month['clicks'],
                $ctr
            );
        }
        return $months_display;
    }
    
    function prepareMonthlySiteKeywordEffectivenessForDisplay($months)
    {
        $months_display = array();
        foreach ($months as $month) {
            $ctr = $this->calculateClickthroughRatioForDisplay($month);
            $months_display[] = array(
                substr($month['yearmonth'], 0, 4).'-'.substr($month['yearmonth'], 4, 2),
                $month['site'],
                $month['keyword'],
                $month['impressions'],
                $month['clicks'],
                $ctr
            );
        }
        return $months_display;
    }
    
    function calculateClickthroughRatioForDisplay($single_line, $prefix = '')
    {
        $views_key = $prefix . 'impressions';
        $clicks_key = $prefix . 'clicks';
        $views = $single_line[$views_key];
        $clicks = $single_line[$clicks_key];
        if ($views > 0) {
            $ctr = ($clicks / $views);
        } else {
            $ctr = false;
        }
        return $ctr;
    }
    
    function useReportWriter(&$writer)
    {
        $this->_report_writer =& $writer;
    }
    
    function formatDateForDisplay($date_string)
    {
        if ($date_string == '0000-00-00') {
            return false;
        }
        $date_object = new Date($date_string);
        $formatted_date = $date_object->format('%Y-%m-%d');
        return $formatted_date;
    }
    
    function getDisplayableParametersFromDaySpan($oDaySpan)
    {
        $aParams = array();
        if (!is_null($oDaySpan)) {
            $aParams['Start date'] = $oDaySpan->getStartDateString();
            $aParams['End date'] = $oDaySpan->getEndDateString();
        }
        return $aParams;
    }
    
    function getDisplayableParametersFromCampaignId($campaign_id)
    {
        $params = array();
        $campaign = Admin_DA::getPlacement($campaign_id);
        $campaign_name = MAX_getPlacementName($campaign);
        $advertiser_name = $this->dal->getAdvertiserNameForCampaign($campaign_id);
        $campaign['anonymous'] == 't' ? $campaignAnonymous = true : $campaignAnonymous = false;
        $advertiser_name = MAX_getAdvertiserName($advertiser_name, null, $campaignAnonymous);
        $key = MAX_Plugin_Translation::translate('Advertiser', $this->module);
        $params[$key] = $advertiser_name;
        $key = MAX_Plugin_Translation::translate('Campaign', $this->module);
        $params[$key] = $campaign_name;
        return $params;
    }
    
    function getDisplayableParametersFromScope($oScope)
    {
        $aParams = array();
        
        $key = MAX_Plugin_Translation::translate('Advertiser', $this->module);
        $advertiserId = $oScope->getAdvertiserId();
        if (!empty($advertiserId)) {
            $advertiser_name = $this->dal->getNameForAdvertiser($advertiserId);
            $aParams[$key] = $advertiser_name;
        } else {
            if ($oScope->getAnonymous()) {
                $aParams[$key] = MAX_Plugin_Translation::translate('Anonymous advertisers', $this->module);
            } else {
                $aParams[$key] = MAX_Plugin_Translation::translate('All advertisers', $this->module);
            }
        }
        
        $key = MAX_Plugin_Translation::translate('Publisher', $this->module);
        $publisherId = $oScope->getPublisherId();
        if (!empty($publisherId)) {
            $publisher_name = $this->dal->getNameForPublisher($publisherId);
            $aParams[$key] = $publisher_name;
        } else {
            if ($oScope->getAnonymous()) {
                $aParams[$key] = MAX_Plugin_Translation::translate('Anonymous publishers', $this->module);
            } else {
                $aParams[$key] = MAX_Plugin_Translation::translate('All publishers', $this->module);
            }
        }
        
        return $aParams;
    }
    
    /**
     * Add a value partway through a numberically-indexed array.
     * 
     * @param int   $slice_position Zero-based array index at which to insert
     * @param array $array          Array to work on
     * @param mixed $value          Value to insert (can be any type)
     * @return array An array that is one element longer than the original
     */
    function insertColumnAtPosition($slice_position, $array, $value)
    {
        $before = array_slice($array, 0, $slice_position);
        $after = array_slice($array, $slice_position);
        $result = array_merge($before, array($value), $after);
        return $result;
    }
    
    /**
     * Return section headers and data from a statsController instance
     * 
     * @param string statsController type
     * @return array An array containing headers (key 0) and data (key 1)
     */
    function getHeadersAndDataFromStatsController($controller_type)
    {
        $statsController = &StatsControllerFactory::newStatsController($controller_type, array(
            'skipFormatting' => true,
            'disablePager'   => true
        ));
        
        $stats = $statsController->exportArray();

        $aHeaders = array();
        foreach ($stats['headers'] as $k => $v) {
            switch ($stats['formats'][$k]) {
                case 'default':
                    $aHeaders[$v] = 'numeric';
                    break;
                case 'currency':
                    $aHeaders[$v] = 'decimal';
                    break;
                case 'percent':
                case 'date':
                case 'time':
                    $aHeaders[$v] = $stats['formats'][$k];
                    break;
                case 'text':
                default:
                    $aHeaders[$v] = 'text';
                    break;
            }
        }
        
        $aData = array();
        foreach ($stats['data'] as $i => $row)
        {
            foreach ($row as $k => $v) {
                $aData[$i][] = $stats['formats'][$k] == 'datetime' ? $this->_report_writer->convertToDate($v) : $v;
            }
        }
        
        return array($aHeaders, $aData);
    }
}
?>