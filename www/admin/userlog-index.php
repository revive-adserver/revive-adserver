<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id: userlog-index.php 12319 2007-11-13 17:34:03Z aj.tarachanowicz@openads.org $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/Field/AuditDaySpanField.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once 'Pager/Pager.php';
require_once MAX_PATH . '/lib/OA/Translation.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.4");
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "My Account" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4"));
    phpAds_UserlogSelection("index");
} else {
    // Show the "Preferences", "User Log" and "Channel Management" sections of the "My Account" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.7"));
}


// Register input variables
$advertiserId   = MAX_getValue('advertiserId',    0);
$campaignId     = MAX_getValue('campaignId',      0);
$publisherId    = MAX_getValue('publisherId',     0);
$zoneId         = MAX_getValue('zoneId',          0);
$startDate      = MAX_getStoredValue('period_start', null);
$endDate        = MAX_getStoredValue('period_end', null);
$periodPreset   = MAX_getValue('period_preset', 'all_events');

//  paging related input variables
$listorder      = MAX_getStoredValue('listorder',       'updated');
$orderdirection = MAX_getStoredValue('orderdirection',  'up');
$setPerPage     = MAX_getStoredValue('setPerPage',      10);
$pageID         = MAX_getStoredValue('pageID',          1);

//  setup date selector
$aPeriod = array(
    'period_preset'     => $periodPreset,
    'period_start'      => $startDate,
    'period_end'        => $endDate
);
$daySpan = new OA_Admin_UI_Audit_DaySpanField('period');
$daySpan->setValueFromArray($aPeriod);
$daySpan->enableAutoSubmit();

//  initialize parameters
$pageName = basename($_SERVER['PHP_SELF']);

//  load template
$oTpl = new OA_Admin_Template('userlog-index.html');

//  get advertisers & publishers for filters
$agencyId = OA_Permission::getAgencyId();
$advertiser = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
$aAdvertiser[0] = $GLOBALS['strSelectAdvertiser'];
foreach($advertiser as $key => $aValue) {
    $aAdvertiser[$aValue['advertiser_id']] = $aValue['name'];
}
$aCampaign = array();
if (!empty($advertiserId)) {
    $campaign = Admin_DA::getCampaigns(array('client_id' => $advertiserId));
    $aCampaign[0] = $GLOBALS['strSelectPlacement'];
    foreach($campaign as $key => $aValue) {
        $aCampaign[$aValue['campaign_id']] = $aValue['campaignname'];
    }
}
$publisher = Admin_DA::getPublishers(array('agency_id' => $agencyId));
$aPublisher[0] = $GLOBALS['strSelectPublisher'];
foreach ($publisher as $key => $aValue) {
    $aPublisher[$aValue['publisher_id']] = $aValue['name'];
}
if (!empty($publisherId)) {
    $zone = Admin_DA::getZones(array('publisher_id' => $publisherId));
    $aZone[0] = $GLOBALS['strSelectZone'];
    foreach ($zone as $key => $aValue) {
        $aZone[$aValue['zone_id']] = $aValue['name'];
    }
}

$oTrans = new OA_Translation();

$aParams = array(
    'advertiser_id' => $advertiserId,
    'campaign_id'   => $campaignId,
    'publisher_id'  => $publisherId,
    'zone_id'       => $zoneId,
    'order'         => $orderdirection,
    'listorder'     => $listorder,
    'start_date'    => $startDate,
    'end_date'      => $endDate,
    'prevImg'       => '<< ' . $oTrans->translate('Back'),
    'nextImg'       => $oTrans->translate('Next') . ' >>'
);

// Account security
if (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    $aParams['account_id'] = OA_Permission::getAccountId();
}

$oUserlog = & new OA_Dll_Audit();
$aAuditData = $oUserlog->getAuditLog($aParams);

$aParams['totalItems'] = count($aAuditData);

if (!isset($pageID) || $pageID == 1) {
    $aParams['startRecord'] = 0;
} else {
    $aParams['startRecord'] = ($pageID * $setPerPage) - $setPerPage;
}

if ($aParams['startRecord'] > $aParams['totalItems']) {
    $aParams['startRecord'] = 0;
}

$aParams['perPage'] = MAX_getStoredValue('setPerPage', 10);

//  retrieve audit details
$aAuditData = $oUserlog->getAuditLog($aParams);

$pager = & Pager::factory($aParams);
$per_page = $pager->_perPage;
$pager->history = $pager->getPageData();
$pager->pagerLinks = $pager->getLinks();

$pager->pagerLinks = $pager->pagerLinks['all'];
$pager->pagerSelect = preg_replace('/(<select.*?)(>)/i', '$1 onchange="submitForm()" id="setPerPage"$2', $pager->getPerPageSelectBox(10, 100, 10));

//  build column header link params
$aAllowdParams = array('advertiserId', 'campaignId', 'publisherId', 'zoneId');
foreach ($aAllowdParams as $key) {
    if (!empty($$key)) {
        $aUrlParam[$key] = "$key=".$$key;
    }
}

$aUrlParam['listorder']         = "listorder=$listorder";
$aUrlParam['$orderdirection']   = ($orderdirection == 'down') ? "orderdirection=up" : "orderdirection=down";

$urlParam = implode('&', $aUrlParam);

//  assign vars to template
$oTpl->assign('aAuditData',         $aAuditData);
$oTpl->assign('aPeriodPreset',      $aPeriodPreset);
$oTpl->assign('aAdvertiser',        $aAdvertiser);
$oTpl->assign('aCampaign',          $aCampaign);
$oTpl->assign('aPublisher',         $aPublisher);
$oTpl->assign('aZone',              $aZone);
$oTpl->assign('context',            $context);
$oTpl->assign('advertiserId',       $advertiserId);
$oTpl->assign('campaignId',         $campaignId);
$oTpl->assign('publisherId',        $publisherId);
$oTpl->assign('zoneId',             $zoneId);
$oTpl->assign('urlParam',           $urlParam);
$oTpl->assign('listorder',          $listorder);
$oTpl->assign('orderdirection',     $orderdirection);
$oTpl->assign('setPerPage',         $setPerPage);
$oTpl->assign('pager',              $pager);
$oTpl->assign('daySpan',            $daySpan);

//  display page
$oTpl->display();

//  display footer
phpAds_PageFooter();

//  store filter variables in session
$session['prefs'][$pageName]['advertiserId']    = $advertiserId;
$session['prefs'][$pageName]['campaignId']      = $campaignId;
$session['prefs'][$pageName]['publisherId']     = $publisherId;
$session['prefs'][$pageName]['zoneId']          = $zoneId;
$session['prefs'][$pageName]['period_preset']   = $periodPreset;
$seesion['prefs'][$pageName]['setPerPage']      = $setPerPage;
$session['prefs'][$pageName]['listorder']       = $listorder;
$session['prefs'][$pageName]['orderdirection']  = $orderdirection;

phpAds_SessionDataStore();
?>
