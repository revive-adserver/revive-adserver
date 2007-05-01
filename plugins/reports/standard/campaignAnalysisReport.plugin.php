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
 * Campaign Analysis report for Openads
 *
 * @since Openads v2.3.19-alpha - Mar 3, 2006
 * @copyright 2003-2007 Openads Limited
 * @version $Id$
 */

require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';
require_once MAX_PATH . '/plugins/reports/ExcelReports.php';

class Plugins_Reports_Standard_CampaignAnalysisReport extends EnhancedReport //Plugins_ExcelReports
{
    /* @var int */
    var $_campaign_id;
    /* @var DaySpan */
    var $_daySpan;

    function info()
    {
        $this->_name = 'Campaign Analysis Report';
        $this->_description = 'This report shows a breakdown of advertising for a particular campaign, by day, banner, and zone.';
        $this->_category = 'standard';
        $this->_categoryName = 'Standard Reports';
        $this->_author = 'Rob Hunter';
        $this->_authorize = phpAds_Admin + phpAds_Agency + phpAds_Advertiser;

        $this->_import = $this->getDefaults();
        $this->saveDefaults();

        return $this->infoArray();
    }

    function getDefaults()
    {
        global $session;

        $aImport = array();

        $default_campaign = isset($session['prefs']['GLOBALS']['report_campaign']) ? $session['prefs']['GLOBALS']           ['report_campaign'] : '';
        $aImport['campaign'] = array(
            'title' => MAX_Plugin_Translation::translate('Campaign', $this->module, $this->package),
            'type' => 'campaignid-dropdown',
            'default' =>  $default_campaign
        );

        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        $aImport['period'] = array(
            'title' => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
            'type' => 'date-month',
            'default' => $default_period_preset
        );

        $aImport['sheets'] = array(
            'title'  => MAX_Plugin_Translation::translate('Worksheets', $this->module, $this->package),
            'type'   => 'sheet',
            'sheets' => array(
                'daily_breakdown' => MAX_Plugin_Translation::translate('Daily breakdown', $this->module, $this->package),
                'ad_breakdown'    => MAX_Plugin_Translation::translate('Ad breakdown', $this->module, $this->package),
                'zone_breakdown'  => MAX_Plugin_Translation::translate('Zone breakdown', $this->module, $this->package)
            )
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['campaign'])) {
            $session['prefs']['GLOBALS']['report_campaign'] = $_REQUEST['campaign'];
        }
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset'] = $_REQUEST['period_preset'];
        }
        phpAds_SessionDataStore();
    }

    function getReportParametersForDisplay()
    {
        $params = array();
        $params += $this->getDisplayableParametersFromCampaignId($this->_campaign_id);
        $params += $this->getDisplayableParametersFromDaySpan($this->_daySpan);
        return $params;
    }


    function execute($campaign_id, $oDaySpan, $sheets)
    {
        $this->_campaign_id = $campaign_id;
        $this->_daySpan = $oDaySpan;
        $startDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getStartDateString())): 'Beginning';
        $endDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getEndDateString())): date('Y-M-d');

        $reportName = $this->_name . ' from ' . $startDate . ' to ' . $endDate . '.xls';
        $this->_report_writer->openWithFilename($reportName);

        if (isset($sheets['daily_breakdown']) || !count($sheets)) {
            $this->addDailyEffectivenessSheet();
        }
        if (isset($sheets['ad_breakdown'])) {
            $this->addBannerEffectivenessSheet();
        }
        if (isset($sheets['zone_breakdown'])) {
            $this->addZoneEffectivenessSheet();
        }

        $this->_report_writer->closeAndSend();
    }

    function addDailyEffectivenessSheet()
    {
        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['breakdown'] = 'day';

        if (phpAds_isUser(phpAds_Affiliate)) {
            $controller_type = 'affiliate-campaign-history';
        } else {
            $controller_type = 'campaign-history';
        }

        $_REQUEST['clientid'] = $this->dal->getAdvertiserIdByCampaignId($this->_campaign_id);
        $_REQUEST['campaignid'] = $this->_campaign_id;

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->createSubReport('Daily breakdown', $aHeaders, $aData);
    }

    function addBannerEffectivenessSheet()
    {
        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['expand']     = 'none';
        $_REQUEST['startlevel'] = 0;

        if (phpAds_isUser(phpAds_Affiliate)) {
            $controller_type = 'affiliate-campaigns';
            $_REQUEST['startlevel'] = 1;
        } else {
            $controller_type = 'campaign-banners';
        }

        $_REQUEST['clientid'] = $this->dal->getAdvertiserIdByCampaignId($this->_campaign_id);
        $_REQUEST['campaignid'] = $this->_campaign_id;

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->createSubReport('Ad breakdown', $aHeaders, $aData);
    }

    function addZoneEffectivenessSheet()
    {
        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['expand']     = 'none';
        $_REQUEST['startlevel'] = 0;

        if (phpAds_isUser(phpAds_Affiliate)) {
            $controller_type = 'affiliate-zones';
        } else {
            $controller_type = 'campaign-affiliates';
            $_REQUEST['startlevel'] = 1;
        }

        $_REQUEST['clientid'] = $this->dal->getAdvertiserIdByCampaignId($this->_campaign_id);
        $_REQUEST['campaignid'] = $this->_campaign_id;

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->createSubReport('Zone breakdown', $aHeaders, $aData);
    }

    function prepareAdvertEffectivenessForDisplay($ads_data)
    {
        $count = 0;
        $effectiveness = array();
        $campaign = Admin_DA::getPlacement($this->_campaign_id);
        $campaign['anonymous'] == 't' ? $campaignAnonymous = true : $campaignAnonymous = false;
        foreach ($ads_data as $ad) {
            $ctr = $this->calculateClickthroughRatioForDisplay($ad);
            $effectiveness[$count][0] = $ad['id'];
            $adDescription = MAX_getAdName($ad['description'], null, null, $campaignAnonymous);
            $effectiveness[$count][1] = $adDescription;
            $effectiveness[$count][2] = $ad['impressions'];
            $effectiveness[$count][3] = $ad['clicks'];
            $effectiveness[$count][4] = $ctr;
            $count++;
        }
        return $effectiveness;
    }
}
?>
