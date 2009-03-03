<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id: market-stats.php 31666 2009-01-29 19:24:16Z lukasz.wikierski $
*/

require_once 'market-common.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/DaySpanField.php';

// No cache
MAX_commonSetNoCacheHeaders();

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADMIN);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    OA_Permission::enforceAccessToObject('agency', OA_Permission::getAgencyId());
}

$oComponent = OX_Component::factory('admin', 'oxMarket');
//check if you can see this page
//$oMarketComponent->checkActive();

displayPage($oComponent);

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oComponent)
{
    global $session;

    //get template and display form
    $pageName = basename($_SERVER['PHP_SELF']);

    $affiliateId    = MAX_getStoredValue('affiliateid', null);
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) && isset($affiliateId)) {
        OA_Permission::enforceAccessToObject('affiliates', $affiliateId);
    }

    $orderdirection = MAX_getStoredValue('orderdirection', '');
    $listorder      = MAX_getStoredValue('listorder', '');
    $periodPreset   = MAX_getStoredValue('period_preset', null);
    if ($periodPreset == 'all_stats') {
        unset($session['prefs']['GLOBALS']['period_start']);
        unset($session['prefs']['GLOBALS']['period_end']);
        $_REQUEST['period_preset'] = $periodPreset;
        $session['prefs']['GLOBALS']['period_preset'] = $periodPreset;
    } else {
        $startDate      = MAX_getStoredValue('period_start', null);
        $endDate        = MAX_getStoredValue('period_end', null);
    }
    $startDate      = (!empty($startDate)) ? date('Y-m-d', strtotime($startDate)) : '';
    $endDate        = (!empty($endDate)) ? date('Y-m-d', strtotime($endDate)) : null;



    $aOption = array(
        'affiliateid'       => $affiliateId,
        'orderdirection'    => $orderdirection,
        'listorder'         => $listorder,
        'period_preset'     => $periodPreset,
        'period_start'      => $startDate,
        'period_end'        => $endDate
    );

    $oDaySpan = new Admin_UI_DaySpanField('period');
    $oDaySpan->setValueFromArray($aOption);
    $oDaySpan->enableAutoSubmit();

    OA_Admin_UI::queueMessage ( 'OpenX Market Reports are not real time statistics', 'local', 'info', 0 );

    //header
    phpAds_PageHeader("openx-market-stats",'','../../');

    $tmpl = (is_null($affiliateId)) ? 'market-stats-website.html' : 'market-stats-zone.html';
    $oTpl = new OA_Plugin_Template($tmpl, 'openXMarket');
    $oReport = OA_Dal::factoryDO('ext_market_web_stats');
    if (!is_null($affiliateId)) {
        $aReportData = $oReport->getSizeStatsByAffiliateId($aOption);
        $oTpl->assign('url', "market-stats.php?affiliateid=$affiliateId");
        $oTpl->assign('affiliateid', $affiliateId);
    }
    else {
        $aReportData['websites'] = $oReport->getWebsiteStatsByAgencyId($aOption);

        // Init nodes
        $aNodes   = MAX_getStoredArray('nodes', array());
        if (count($aNodes) == 1 && empty($aNodes[0])) {
            $aNodes = array();
        }
        $expand   = MAX_getValue('expand', '');
        $collapse = MAX_getValue('collapse');

        // Adjust which nodes are opened closed...
        MAX_adjustNodes($aNodes, $expand, $collapse);
        foreach ($aReportData['websites'] as $aWebsiteStats) {
            $websiteId = $aWebsiteStats['id'];
            MAX_isExpanded($websiteId, $expand, $aNodes, ''); //this updates aNodes if necessary
        }
        $aReportData['zones'] = array();
        if ($expand === "all") {
            $oReport = OA_Dal::factoryDO('ext_market_web_stats');
            $aReportData['zones'] = $oReport->getSizeStatsForAffiliates($aOption);
        }
        else {
            if (!empty($aNodes)) {
                $aOption['aAffiliateids'] = $aNodes;
                $oReport = OA_Dal::factoryDO('ext_market_web_stats');
                $aReportData['zones'] = $oReport->getSizeStatsForAffiliates($aOption);
                unset($aOption['aAffiliateids']);
            }
        }
    }

    $oTpl->assign('aReportData',    $aReportData);
    $oTpl->assign('daySpan',        $oDaySpan);
    $oTpl->assign('period_start', MAX_getStoredValue('period_start', null));
    $oTpl->assign('period_end', MAX_getStoredValue('period_end', null));
    $oTpl->assign('period_preset', MAX_getStoredValue('period_preset', null));
    $oTpl->assign('listorder',      $listorder);
    $oTpl->assign('orderdirection', $orderdirection);
    $oTpl->display();

    //footer
    phpAds_PageFooter();

    $session['prefs'][$pageName]['listorder'] = $listorder;
    $session['prefs'][$pageName]['orderdirection'] = $orderdirection;
    if (is_array($aNodes)) {
        $session['prefs'][$pageName]['nodes'] =  implode (",", $aNodes);
    }
    $session['prefs']['GLOBALS']['period_start'] = $startDate;
    $session['prefs']['GLOBALS']['period_end'] = $endDate;
    $session['prefs']['GLOBALS']['period_preset'] = $periodPreset;

    phpAds_SessionDataStore();
}

?>
