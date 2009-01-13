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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/common.php';

// OA-900, hide graph
OA_Permission::enforceTrue(false);

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';

// Make data loading depending only on period_start & period_end
$tempPeriodPreset = $_REQUEST['period_preset'];
$_REQUEST['period_preset'] = 'specific';
$period_preset = 'specific';
$session['prefs']['GLOBALS']['period_preset'] = 'specific';
$period_preset = MAX_getStoredValue('period_preset', 'today');

phpAds_registerGlobal('breakdown', 'entity', 'agency_id', 'advertiser_id',
                      'clientid', 'campaignid', 'placement_id', 'ad_id',
                      'bannerid', 'publisher_id', 'affiliateid', 'zone_id',
                      'zoneid', 'start_date', 'end_date', 'sort', 'asc',
                      'show', 'expand', 'day', 'plugin', 'peroid_preset',
                      'tempPeriodPreset', 'GraphFile', 'graphFilter','graphFields',
                      'listorder'
                     );

if (!isset($listorder)) {
    $prm['listorder'] = MAX_getStoredValue('listorder', null, 'stats.php');
}

// Handle filters
if (is_numeric($advertiser_id)) {
    $clientid = $advertiser_id;
}

if (is_numeric($placement_id)) {
    $campaignid = $placement_id;
}

if (is_numeric($ad_id)) {
    $bannerid = $ad_id;
}

if (is_numeric($publisher_id)) {
    $affiliateid = $publisher_id;
}

if (is_numeric($zone_id)) {
      $zoneid = $zone_id;
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

// Overwirte file name to load right session data, see MAX_getStoredValue
$pgName = 'stats.php';

$oStats = &OA_Admin_Statistics_Factory::getController($entity . "-" . $breakdown);
if (PEAR::isError($oStats)) {
    phpAds_Die('Error occured', $oStats->getMessage());
}
$oStats->noFormat = true;
$oStats->start();

// Output html code
$oStats->output(true);

// Erase stats graph file
if (isset($GraphFile) && $GraphFile != '') {
    $dirObject = dir( $conf['store']['webDir'] . '/temp');
    while (false !== ($entry = $dirObject->read())) {
        if (filemtime($conf['store']['webDir'] . '/temp/' . $entry) + 60 < time()) {
            unlink($conf['store']['webDir'] . '/temp/' . $entry);
        }
    }
}


?>