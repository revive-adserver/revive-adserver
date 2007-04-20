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
$Id:advertisingAnalysisReport.plugin.php 114 2006-03-03 14:32:10Z roh@m3.net $
*/

/**
 * Advertising Analysis report plug-in for Openads
 *
 * @since 0.3.19 - Feb 20, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id:advertisingAnalysisReport.plugin.php 65 2006-02-24 16:51:48Z roh@m3.net $
 */

require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';
require_once MAX_PATH . '/plugins/reports/ExcelReports.php';
require_once MAX_PATH . '/lib/max/Admin/Reporting/ReportScope.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

class Plugins_Reports_Standard_AdvertisingAnalysisReport extends EnhancedReport
{
    /* @var ReportScope */
    var $_scope;

    /* @var DaySpan */
    var $_daySpan;

    function initInfo()
    {
        $this->_name = MAX_Plugin_Translation::translate('Advertising Analysis Report', $this->module, $this->package);
        $this->_description = MAX_Plugin_Translation::translate('This report shows a breakdown of advertising for a particular advertiser or publisher, by day, campaign, and zone.', $this->module, $this->package);
        $this->_category = 'standard';
        $this->_categoryName = MAX_Plugin_Translation::translate('Standard Reports', $this->module, $this->package);
        $this->_author = 'Rob Hunter';
        $this->_authorize = phpAds_Admin + phpAds_Agency + phpAds_Affiliate;

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
    }

    function getDefaults()
    {
        global $session;

        $aImport = array();

        $default_scope_advertiser = isset($session['prefs']['GLOBALS']['report_scope_advertiser']) ? $session['prefs']['GLOBALS']['report_scope_advertiser'] : '';
        $default_scope_publisher = isset($session['prefs']['GLOBALS']['report_scope_publisher']) ? $session['prefs']['GLOBALS']['report_scope_publisher'] : '';
        $aImport['scope'] = array(
            'title' => MAX_Plugin_Translation::translate('Limitations', $this->module, $this->package),
            'type' => 'scope',
            'scope_advertiser' => $default_scope_advertiser,
            'scope_publisher' => $default_scope_publisher
        );

        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        $aImport['period'] = array(
            'title' => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
            'type' => 'date-month',
            'default' => $default_period_preset
        );

        $sheets = array(
            'daily_breakdown'    => MAX_Plugin_Translation::translate('Daily breakdown', $this->module, $this->package),
            'campaign_breakdown' => MAX_Plugin_Translation::translate('Campaign breakdown', $this->module, $this->package)
        );
        if (!phpAds_isUser(phpAds_Affiliate) || phpAds_isAllowed(MAX_AffiliateViewZoneStats)) {
            $sheets['zone_breakdown'] = MAX_Plugin_Translation::translate('Zone breakdown', $this->module, $this->package);
        }
        $aImport['sheets'] = array(
            'title'  => MAX_Plugin_Translation::translate('Worksheets', $this->module, $this->package),
            'type'   => 'sheet',
            'sheets' => $sheets
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['scope_advertiser'])) {
            $session['prefs']['GLOBALS']['report_scope_advertiser'] = $_REQUEST['scope_advertiser'];
        }
        if (isset($_REQUEST['scope_publisher'])) {
            $session['prefs']['GLOBALS']['report_scope_publisher'] = $_REQUEST['scope_publisher'];
        }
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset'] = $_REQUEST['period_preset'];
        }
        phpAds_SessionDataStore();
    }

    function getReportParametersForDisplay()
    {
        $aParams = array();
        $aParams += $this->getDisplayableParametersFromScope($this->_scope);
        $aParams += $this->getDisplayableParametersFromDaySpan($this->_daySpan);
        return $aParams;
    }

    function execute($scope, $oDaySpan, $sheets)
    {
        $this->_scope = $scope;
        $this->_daySpan = $oDaySpan;
        $startDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getStartDateString())): 'Beginning';
        $endDate = !empty($oDaySpan) ? date('Y-M-d', strtotime($oDaySpan->getEndDateString())): date('Y-M-d');
        $reportName = $this->_name . ' from ' . $startDate . ' to ' . $endDate . '.xls';
        $this->_report_writer->openWithFilename($reportName);

        if (isset($sheets['daily_breakdown']) || !count($sheets)) {
            $this->addDailyEffectivenessSheet();
        }
        if (isset($sheets['campaign_breakdown'])) {
            $this->addCampaignEffectivenessSheet();
        }
        if (isset($sheets['zone_breakdown'])) {
            if (!phpAds_isUser(phpAds_Affiliate) || phpAds_isAllowed(MAX_AffiliateViewZoneStats)) {
                $this->addZoneEffectivenessSheet();
            }
        }

        $this->_report_writer->closeAndSend();
    }

    function addDailyEffectivenessSheet()
    {
        require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsControllerFactory.php';

        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['breakdown'] = 'day';

        if (phpAds_isUser(phpAds_Admin|phpAds_Agency)) {
            if (!empty($this->_scope->_advertiserId) && !empty($this->scope->_publisherId)) {
                $controller_type = 'advertiser-affiliate-history';
            } elseif (!empty($this->_scope->_advertiserId)) {
                $controller_type = 'advertiser-history';
            } elseif (!empty($this->_scope->_publisherId)) {
                $controller_type = 'affiliate-history';
            } else {
                $controller_type = 'global-history';
            }
        } elseif (phpAds_isUser(phpAds_Client)) {
            if (!empty($this->_scope->_publisherId)) {
                $controller_type = 'advertiser-affiliate-history';
            } else {
                $controller_type = 'advertiser-history';
            }
        } else {
            $controller_type = 'affiliate-history';
        }

        if (!empty($this->_scope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_scope->_advertiserId;
        }
        if (!empty($this->_scope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_scope->_publisherId;
        }

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->createSubReport(MAX_Plugin_Translation::translate('Daily breakdown', $this->module, $this->package), $aHeaders, $aData);
    }

    function addCampaignEffectivenessSheet()
    {
        require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsControllerFactory.php';

        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['expand']     = 'none';
        $_REQUEST['startlevel'] = 0;

        if (phpAds_isUser(phpAds_Admin|phpAds_Agency)) {
            if (!empty($this->_scope->_advertiserId)) {
                $controller_type = 'advertiser-campaigns';
            } elseif (!empty($this->_scope->_publisherId)) {
                $controller_type = 'affiliate-campaigns';
            } else {
                $controller_type = 'global-advertiser';
                $_REQUEST['startlevel'] = 1;
            }
        } elseif (phpAds_isUser(phpAds_Client)) {
            $controller_type = 'advertiser-campaigns';
        } else {
            $controller_type = 'affiliate-campaigns';
        }

        if (!empty($this->_scope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_scope->_advertiserId;
        }
        if (!empty($this->_scope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_scope->_publisherId;
        }

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->createSubReport(MAX_Plugin_Translation::translate('Campaign breakdown', $this->module, $this->package), $aHeaders, $aData);
    }

    function addZoneEffectivenessSheet()
    {
        require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsControllerFactory.php';

        if (is_null($this->_daySpan)) {
            $_REQUEST['period_preset'] = 'all_stats';
        } else {
            $_REQUEST['period_preset'] = 'specific';
            $_REQUEST['period_start']  = $this->_daySpan->getStartDateString();
            $_REQUEST['period_end']    = $this->_daySpan->getEndDateString();
        }
        $_REQUEST['expand']     = 'none';
        $_REQUEST['startlevel'] = 0;

        if (phpAds_isUser(phpAds_Admin|phpAds_Agency)) {
            if (!empty($this->_scope->_advertiserId)) {
                $controller_type = 'advertiser-affiliates';
                $_REQUEST['startlevel'] = 1;
            } elseif (!empty($this->_scope->_publisherId)) {
                $controller_type = 'affiliate-zones';
            } else {
                $controller_type = 'global-affiliates';
                $_REQUEST['startlevel'] = 1;
            }
        } elseif (phpAds_isUser(phpAds_Client)) {
            $controller_type = 'advertiser-affiliates';
            $_REQUEST['startlevel'] = 1;
        } else {
            $controller_type = 'affiliate-zones';
        }

        if (!empty($this->_scope->_advertiserId)) {
            $_REQUEST['clientid'] = $this->_scope->_advertiserId;
        }
        if (!empty($this->_scope->_publisherId)) {
            $_REQUEST['affiliateid'] = $this->_scope->_publisherId;
        }

        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($controller_type);

        $this->createSubReport(MAX_Plugin_Translation::translate('Zone breakdown', $this->module, $this->package), $aHeaders, $aData);
    }
}
?>
