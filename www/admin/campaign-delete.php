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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/DB.php';

// Register input variables
phpAds_registerGlobal ('returnurl');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency)) {
    $belongToUser = false;
    if (!empty($campaignid)) {
        $doCampaign = MAX_DB::factoryDO('campaigns');
        $doCampaign->campaignid = $campaignid;
        $belongToUser = $doCampaign->belongToUser('agency', phpAds_getUserID());
    } else {
        $doClient = MAX_DB::factoryDO('clients');
        $doClient->clientid = $clientid;
        $belongToUser = $doClient->belongToUser('agency', phpAds_getUserID());
    }
    if (!$belongToUser) {
        phpAds_PageHeader("2");
        phpAds_Die ($strAccessDenied, $strNotAdmin);
    }
}

/*-------------------------------------------------------*/
/* Restore cache of $node_array, if it exists            */
/*-------------------------------------------------------*/

if (isset($session['prefs']['advertiser-index.php']['nodes'])) {
    $node_array = $session['prefs']['advertiser-index.php']['nodes'];
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($campaignid)) {
    $doCampaign = MAX_DB::factoryDO('campaigns');
    $doCampaign->campaignid = $campaignid;
    $doCampaign->delete();
    // Find and delete the campains from $node_array, if
    // necessary. (Later, it would be better to have
    // links to this file pass in the clientid as well,
    // to facilitate the process below.
    if (!empty($node_array['clients'])) {
        foreach ($node_array['clients'] as $key => $val) {
            if (isset($node_array['clients'][$key]['campaigns'])) {
                unset($node_array['clients'][$key]['campaigns'][$campaignid]);
            }
        }
    }
}

// Run the Maintenance Priority Engine process
MAX_Maintenance_Priority::run();

// Rebuild cache
// include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
// phpAds_cacheDelete();

/*-------------------------------------------------------*/
/* Save the $node_array, if necessary                    */
/*-------------------------------------------------------*/

if (isset($node_array)) {
    $session['prefs']['advertiser-index.php']['nodes'] = $node_array;
    phpAds_SessionDataStore();
}

/*-------------------------------------------------------*/
/* Return to the index page                              */
/*-------------------------------------------------------*/

if (empty($returnurl)) {
    $returnurl = 'advertiser-campaigns.php';
}

header ("Location: ".$returnurl."?clientid=".$clientid);

?>
