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
$Id$
*/

// Require the initialisation file
// Note that MAX_PATH will have been defined by the invocated code
require_once MAX_PATH . '/init-delivery.php';

// Include required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';

// This function is a wrapper to view raw, this allows for future migration
function view_local($what, $zoneid = 0, $campaignid = 0, $bannerid = 0, $target = '', $source = '', $withtext = '', $context = '') {
    // start stacked output buffering
    ob_start();

    if (!((strstr($what, 'zone')) or (strstr($what, 'campaign')) or (strstr($what, 'banner')))) {
        if ($zoneid) {
            $what = "zone:".$zoneid;
        }
        if ($campaignid) {
            $what = "campaignid:".$campaignid;
        }
        if ($bannerid) {
            $what = "bannerid:".$bannerid;
        }
    }
    // init-variables will have set "loc" to $_SERVER['HTTP_REFERER']
    // however - in local mode (only), this is not the case
    global $loc, $referer;
    $referer = $loc;
    $loc = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.
        getHostName() .
		$_SERVER['REQUEST_URI'];

    $output = MAX_adSelect($what, '', $target, $source, $withtext, $context, true, '', $loc, $referer);
    if (isset($output['contenttype']) && $output['contenttype'] == 'swf') {
        $output['html'] = MAX_flashGetFlashObjectExternal() . $output['html'];
    }
    // Add any $context information to the global phpAds_context array
    if (
        isset($GLOBALS['phpAds_context']) && is_array($GLOBALS['phpAds_context']) &&
        isset($output['context']) && is_array($output['context'])
       ) {
           // Check if the new context item is already in the global array, and add it if not
           foreach ($GLOBALS['phpAds_context'] as $idx => $item) {
               foreach ($output['context'] as $newidx => $newItem) {
                   if ($newItem === $item) {
                       unset($output['context'][$newidx]);
                   }
               }
           }
        $GLOBALS['phpAds_context'] = $GLOBALS['phpAds_context'] + $output['context'];
    }
    MAX_cookieFlush();
    // add cookies to output html
    $output['html'] .= ob_get_clean();
    return $output;
}

?>
