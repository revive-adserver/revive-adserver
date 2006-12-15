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
$Id: alocal.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

// Require the initialisation file
// Note that MAX_PATH will have been defined by the invocated code
require_once MAX_PATH . '/init-delivery.php';

// Include required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';

// This function is a wrapper to view raw, this allows for future migration
function view_local($what, $zoneid = 0, $campaignid = 0, $bannerid = 0, $target = '', $source = '', $withtext = '', $context = '') {
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
    $output = MAX_adSelect($what, $target, $source, $withtext, $context, true, '', $GLOBALS['loc'], $GLOBALS['referer']);
    if ($output['contenttype'] == 'swf') {
        $output['html'] = MAX_flashGetFlashObjectExternal() . $output['html'];
    }
    return $output;
}

?>
