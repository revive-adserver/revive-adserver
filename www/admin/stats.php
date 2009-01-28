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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/www/admin/config.php';

require_once MAX_PATH . '/lib/OA/Admin/DaySpan.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';
require_once MAX_PATH . '/lib/pear/Date.php';

// No cache
MAX_commonSetNoCacheHeaders();

// The URL for stats pages may include values for "period_preset",
// "period_start" and "period_end". However, the user may have
// bookmarked or emailed a statsistics URL, and so the page may
// be viewed on a day that is NOT the day the URL was created.
// As a result, the "period_preset" value may no longer match
// the dates. So, to prevent confusion, re-set the "period_preset"
// value to the range that matches the date, if possible - otherwise
// use the "Specific Dates" value. The exception, of course, is
// "".
$periodPreset = MAX_getValue('period_preset', 'today');
if ($periodPreset == 'all_stats') {
    unset($_REQUEST['period_start']);
    unset($session['prefs']['GLOBALS']['period_start']);
    unset($_REQUEST['period_end']);
    unset($session['prefs']['GLOBALS']['period_end']);
    $_REQUEST['period_preset'] = $periodPreset;
    $session['prefs']['GLOBALS']['period_preset'] = $periodPreset;
} else {
    $period_start = MAX_getStoredValue('period_start', date('Y-m-d'));
    if (!strstr($period_start, '-')) {
        $period_start = date('Y-m-d', strtotime($period_start));
        MAX_changeStoredValue('period_start', $period_start);
    }
    $period_end   = MAX_getStoredValue('period_end', date('Y-m-d'));
    if (!strstr($period_end, '-')) {
        $period_end   =  date('Y-m-d', strtotime($period_end));
        MAX_changeStoredValue('period_end', $period_end);
    }
    if (!empty($period_start) && !empty($period_end)) {
        $oStartDate = new Date($period_start);
        $oEndDate   = new Date($period_end);
        $oDaySpan   = new OA_Admin_DaySpan();
        $oDaySpan->setSpanDays($oStartDate, $oEndDate);
        $periodFromDates = $oDaySpan->getPreset();
        $_REQUEST['period_preset'] = $periodFromDates;
        $session['prefs']['GLOBALS']['period_preset'] = $periodFromDates;
    } else {
        $_REQUEST['period_preset'] = $periodPreset;
        $session['prefs']['GLOBALS']['period_preset'] = $periodPreset;
    }
}

phpAds_registerGlobal('breakdown', 'entity', 'agency_id', 'advertiser_id',
                      'clientid', 'campaignid', 'placement_id', 'ad_id',
                      'bannerid', 'publisher_id', 'affiliateid', 'zone_id',
                      'zoneid', 'start_date', 'end_date', 'sort', 'asc',
                      'show', 'expand', 'day', 'plugin', 'peroid_preset',
                      'tempPeriodPreset', 'GraphFile', 'graphFilter','graphFields',
                      'listorder', 'orderdirection'
                     );
$listorder      = htmlspecialchars($listorder);
$orderdirection = htmlspecialchars($orderdirection);
if (!($orderdirection == 'up' || $orderdirection == 'down')) {
    if (stristr($orderdirection, 'down')) {
        $orderdirection = 'down';
    } else {
        $orderdirection = 'up';
    }
}

if (isset($graphFilter) && is_array($graphFilter)) {
    // Remove old filter fileds from link
    $REQUEST_URI = $_SERVER['REQUEST_URI'];
    $REQUEST_URI = preg_replace('/graphFields\[\]=(.*)$/', '', $REQUEST_URI);
    $REQUEST_URI = substr(strrchr($REQUEST_URI, '/'), 1);
    $redirectUrl = MAX::constructUrl(MAX_URL_ADMIN, $REQUEST_URI);

    foreach($graphFilter as $k => $v) {
        $redirectUrl .= '&graphFields[]=' . $v;
    }
    header("Location: $redirectUrl");
    die;
} else {
    $graphFilter = isset($graphFields) ? $graphFields : null;
}

// Handle filters
if (!empty($advertiser_id)) {
    $clientid = (int) $advertiser_id;
}

if (!empty($placement_id)) {
    $campaignid = (int) $placement_id;
}

if (!empty($ad_id)) {
    $bannerid = (int) $ad_id;
}

if (!empty($publisher_id)) {
    $affiliateid = (int) $publisher_id;
}

if (!empty($zone_id)) {
      $zoneid = (int) $zone_id;
}

if (!isset($entity)) {
    $entity = 'global';
}
if (!isset($breakdown)) {
    $breakdown = 'advertiser';
}

// Add all manipulated values to globals
$_REQUEST['zoneid']         = $zoneid;
$_REQUEST['affiliateid']    = $affiliateid;
$_REQUEST['bannerid']       = $bannerid;
$_REQUEST['campaignid']     = $campaignid;
$_REQUEST['clientid']       = $clientid;
$_REQUEST['listorder']      = $listorder;
$_REQUEST['orderdirection'] = $orderdirection;

// If displaying conversion statistics, hand over control to a different file
if ($entity == 'conversions') {
    include_once MAX_PATH . '/www/admin/stats-conversions.php';
    exit;
}

// Prepare the parameters for display or export to XLS
$aParams = null;
if (isset($plugin) && $plugin != '') {
    $aParams = array(
        'skipFormatting' => true,
        'disablePager'   => true
    );
}

// Prepare the stats controller, and populate with the stats
$oStatsController = &OA_Admin_Statistics_Factory::getController($entity . "-" . $breakdown, $aParams);
if (PEAR::isError($oStatsController)) {
    phpAds_Die('Error occured', $oStatsController->getMessage());
}
$oStatsController->start();

// Export to XLS...
if (isset($plugin) && $plugin != '') {
    require_once MAX_PATH . '/lib/OA/Admin/Reports/Export.php';
    $oModule = new OA_Admin_Reports_Export($oStatsController);
    $oModule->export();
}

// ... otherwise, output in HTML
$oStatsController->output();

// Erase stats graph file
if (isset($GraphFile) && $GraphFile != '') {
    $dirObject = dir($conf['store']['webDir'] . '/temp');
    while (false !== ($entry = $dirObject->read())) {
        if (filemtime($conf['store']['webDir'] . '/temp/' . $entry) + 60 < time()) {
            unlink($conf['store']['webDir'] . '/temp/' . $entry);
        }
    }
}

?>
