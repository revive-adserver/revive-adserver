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
$Id: zone-invocation.php 4701 2006-04-18 09:10:21Z matteo@beccati.com $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Affiliate)) {
    $result = phpAds_dbQuery("
        SELECT
            affiliateid
        FROM
            ".$conf['table']['prefix'].$conf['table']['zones']."
        WHERE
            zoneid = '$zoneid'
        ") or phpAds_sqlDie();
    $row = phpAds_dbFetchArray($result);
    if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"]) {
        phpAds_PageHeader("1");
        phpAds_Die($strAccessDenied, $strNotAdmin);
    } else {
        $affiliateid = $row["affiliateid"];
    }
} elseif (phpAds_isUser(phpAds_Agency)) {
    $query = "SELECT z.zoneid as zoneid".
        " FROM ".$conf['table']['prefix'].$conf['table']['affiliates']." AS a".
        ",".$conf['table']['prefix'].$conf['table']['zones']." AS z".
        " WHERE z.affiliateid='".$affiliateid."'".
        " AND z.zoneid='".$zoneid."'".
        " AND z.affiliateid=a.affiliateid".
        " AND a.agencyid=".phpAds_getUserID();
    $res = phpAds_dbQuery($query) or phpAds_sqlDie();
    if (phpAds_dbNumRows($res) == 0) {
        phpAds_PageHeader("2");
        phpAds_Die($strAccessDenied, $strNotAdmin);
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (isset($session['prefs']['affiliate-zones.php']['listorder'])) {
    $navorder = $session['prefs']['affiliate-zones.php']['listorder'];
} else {
    $navorder = '';
}
if (isset($session['prefs']['affiliate-zones.php']['orderdirection'])) {
    $navdirection = $session['prefs']['affiliate-zones.php']['orderdirection'];
} else {
    $navdirection = '';
}

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabIndex = 1;
$agencyId = phpAds_getAgencyID();
$aEntities = array('affiliateid' => $affiliateid, 'zoneid' => $zoneid);

$aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
$aOtherZones = Admin_DA::getZones(array('publisher_id' => $affiliateid));
MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$res = phpAds_dbQuery("
    SELECT
        z.affiliateid,
        z.width,
        z.height,
        z.delivery,
        af.website
    FROM
        {$conf['table']['prefix']}{$conf['table']['zones']} AS z,
        {$conf['table']['prefix']}{$conf['table']['affiliates']} AS af
    WHERE
        z.zoneid=$zoneid
      AND af.affiliateid = z.affiliateid
    ") or phpAds_sqlDie();
if (phpAds_dbNumRows($res)) {
    $zone = phpAds_dbFetchArray($res);
    $extra = array('affiliateid' => $affiliateid, 
                   'zoneid' => $zoneid,
                   'width' => $zone['width'],
                   'height' => $zone['height'],
                   'delivery' => $zone['delivery'],
                   'website' => $zone['website']
    );
    $tabindex = 1;
    // Ensure 3rd Party Click Tracking defaults to the preference for this agency
    if (!isset($thirdpartytrack)) {
        $thirdpartytrack = $GLOBALS['_MAX']['PREF']['gui_invocation_3rdparty_default'];
    }
    $maxInvocation = new MAX_Admin_Invocation();
    echo $maxInvocation->placeInvocationForm($extra, true);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
