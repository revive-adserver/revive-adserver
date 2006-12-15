<?php


/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: stats.php 4624 2006-06-021 14:37:29Z dawid@arlenmedia.com $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/common.php';

//make data loading depending only on period_start & period_end
$tempPeriodPreset = $_REQUEST['period_preset'];
$_REQUEST['period_preset'] = 'specific';
$period_preset = 'specific';
$session['prefs']['GLOBALS']['period_preset'] = 'specific';
$period_preset = MAX_getStoredValue('period_preset', 'today');



require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsControllerFactory.php';

phpAds_registerGlobal('breakdown', 'entity', 'agency_id', 'advertiser_id',
                      'clientid', 'campaignid', 'placement_id', 'ad_id',
                      'bannerid', 'publisher_id', 'affiliateid', 'zone_id',
                      'zoneid', 'start_date', 'end_date', 'sort', 'asc',
                      'show', 'expand', 'day', 'plugin', 'peroid_preset',
                      'tempPeriodPreset', 'GraphFile', 'graphFilter','graphFields',
                      'listorder'
                     );



    if(!isset($listorder)) {
        $prm['listorder'] = MAX_getStoredValue('listorder', null, 'stats.php');    
    }



// handle filters
if(is_numeric($advertiser_id)) {
    $clientid = $advertiser_id;
}

if(is_numeric($placement_id)) {
    $campaignid = $placement_id;
}

if(is_numeric($ad_id)) {
    $bannerid = $ad_id;
}

if(is_numeric($publisher_id)) {
    $affiliateid = $publisher_id;
}

if(is_numeric($zone_id)) {
      $zoneid = $zone_id;
}

if(!isset($entity)) {
    $entity = 'global';
}
if(!isset($breakdown)) {
    $breakdown = 'advertiser';
}

//add all manipulated values to globals
$_REQUEST['zoneid']      = $zoneid;
$_REQUEST['affiliateid'] = $affiliateid;
$_REQUEST['bannerid']    = $bannerid;
$_REQUEST['campaignid']  = $campaignid;
$_REQUEST['clientid']    = $clientid;

//die($entity." ".$breakdown);

//loading non-standard stat files
if($entity == 'campaign' && $breakdown == 'keywords') {

    include_once MAX_PATH . '\www\admin\stats-campaign-keywords.php';
    die;

} else if($entity == 'campaign' && $breakdown == 'optimise') {

    include_once MAX_PATH . '\www\admin\stats-campaign-optimise.php';
    die;

} else if($entity == 'campaign' && $breakdown == 'sources') {

    include_once MAX_PATH . '\www\admin\stats-campaign-sources.php';
    die;

} else if($entity == 'conversions') {

    include_once MAX_PATH . '\www\admin\stat-conversions.php';
    die;

} else if($entity == 'global' && $breakdown == 'misc') {

    include_once MAX_PATH . '\www\admin\stats-global-misc.php';
    die;

} else if($entity == 'linkedbanner' && $breakdown == 'history') {

    include_once MAX_PATH . '\www\admin\stats-linkedbanner-history.php';
    die;

} else if($entity == 'optimise') {

    include_once MAX_PATH . '\www\admin\stats-optimise.php';
    die;

} else if($entity == 'placement' && $breakdown == 'target') {

    include_once MAX_PATH . '\www\admin\stats-placement-target.php';
    die;

} else if($entity == 'placement' && $breakdown == 'target-daily') {

    include_once MAX_PATH . '\www\admin\stats-placement-target.php';
    die;

} else if($entity == 'reset') {

    include_once MAX_PATH . '\www\admin\stats-reset.php';
    die;

} else {

    // Display stats

    //overwirte file name to load right session data, see MAX_getStoredValue
    $pgName = 'stats.php'; 

    $stats = &StatsControllerFactory::newStatsController($entity . "-" . $breakdown);



    //create Excel stats report
    if(isset($plugin) && $plugin != '') {
        include_once MAX_PATH . '\www\admin\stats-report-execute.php';
    }

    //remove comas in values greater than 1000
    foreach($stats->history as $dateKey => $dateRecord) {
        foreach($dateRecord as $k => $v) {
            $stats->history[$dateKey][$k] = ereg_replace(",", "", $v);
        }    
    }


    //output html code
    $stats->output(null, true);

    //erase stats graph file
    if(isset($GraphFile) && $GraphFile != '') {

        $dirObject = dir( $conf['store']['webDir'] . '/temp');    
        while (false !== ($entry = $dirObject->read())) {

            if( filemtime($conf['store']['webDir'] . '/temp/' . $entry) + 60 < time()) {
                unlink($conf['store']['webDir'] . '/temp/' . $entry);
            }
        }
    }



}



?>
