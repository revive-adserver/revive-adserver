<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

phpAds_registerGlobalUnslashed('campaignid', 'status', 'category', 'text', 'category-text');

OA_Permission::enforceAccount ( OA_ACCOUNT_MANAGER );
OA_Permission::enforceAccessToObject ( 'campaigns', $campaignid );

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$agencyId = OA_Permission::getAgencyId();
$oDalZones = OA_Dal::factoryDAL('zones');
$linked = ($status == "linked");
$websites = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $category, $campaignid, $linked, $text);
$aZonesCounts = array (
    'all'     => $oDalZones->countZones($agencyId, null, $campaignid, $linked),
    'showing' => $oDalZones->countZones($agencyId, $category, $campaignid, $linked, $text)
  );

$oTpl = new OA_Admin_Template('campaign-zone-zones.html');
$oTpl->assign('websites', $websites);
$oTpl->assign('category', $category-text);
$oTpl->assign('text', $text);
$oTpl->assign('zonescounts', $aZonesCounts);

if ($linked) {
  $oTpl->assign('status', 'linked');
}
else {
  $oTpl->assign('status', 'available');
}

$oTpl->display();
?>

