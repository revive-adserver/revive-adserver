<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';

// No cache
MAX_commonSetNoCacheHeaders();

// Make data loading depending only on period_start & period_end
$tempPeriodPreset = MAX_getValue('period_preset');
$_REQUEST['period_preset'] = 'specific';
$period_preset = 'specific';
$session['prefs']['GLOBALS']['period_preset'] = 'specific';
$period_preset = MAX_getStoredValue('period_preset', 'today');
$period_start = MAX_getStoredValue('period_start', date('Y-m-d'));
$period_end = MAX_getStoredValue('period_end', date('Y-m-d'));

phpAds_registerGlobal('breakdown', 'entity', 'agency_id', 'advertiser_id',
                      'clientid', 'campaignid', 'placement_id', 'ad_id',
                      'bannerid', 'publisher_id', 'affiliateid', 'zone_id',
                      'zoneid', 'start_date', 'end_date', 'sort', 'asc',
                      'show', 'expand', 'day', 'plugin', 'peroid_preset',
                      'tempPeriodPreset', 'GraphFile', 'graphFilter','graphFields',
                      'listorder', 'orderdirection'
                     );


if (isset($graphFilter) && is_array($graphFilter)) {

    //remove old filter fileds from link
    $REQUEST_URI = $_SERVER['REQUEST_URI'];
    $REQUEST_URI = preg_replace('/graphFields\[\]=(.*)$/', '', $REQUEST_URI);

    $redirectUrl = 'http://'
                   . $_SERVER['SERVER_NAME']
                   . $REQUEST_URI;

    foreach($graphFilter as $k => $v) {
        $redirectUrl .= '&graphFields[]=' . $v;
    }


    header("Location: $redirectUrl");
    die;
} else {
    $graphFilter = isset($graphFields) ? $graphFields : null;
}

// handle filters
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
$_REQUEST['zoneid']      = $zoneid;
$_REQUEST['affiliateid'] = $affiliateid;
$_REQUEST['bannerid']    = $bannerid;
$_REQUEST['campaignid']  = $campaignid;
$_REQUEST['clientid']    = $clientid;

// Display stats
if ($entity == 'conversions') {
    include_once MAX_PATH . '/www/admin/stats-conversions.php';
    exit;
}

$oStats = &OA_Admin_Statistics_Factory::getController($entity . "-" . $breakdown);
$oStats->start();

// Create Excel stats report
if (isset($plugin) && $plugin != '') {
    include_once MAX_PATH . '/www/admin/stats-report-execute.php';
}

//output html code
$oStats->output();

//erase stats graph file
if (isset($GraphFile) && $GraphFile != '') {

    $dirObject = dir($conf['store']['webDir'] . '/temp');
    while (false !== ($entry = $dirObject->read())) {

        if (filemtime($conf['store']['webDir'] . '/temp/' . $entry) + 60 < time()) {
            unlink($conf['store']['webDir'] . '/temp/' . $entry);
        }
    }
}


?>
