<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$agencyId   = OA_Permission::getAgencyId();
$oDalZones  = OA_Dal::factoryDAL('zones');
$action     = $_REQUEST["action"];
$campaignId = $_REQUEST['campaignid'];

$aZonesIds = array();
$aZonesIdsHash = array();
foreach ($_REQUEST['ids'] as $zone) {
    if (substr($zone, 0, 1) == 'z') {
        $aZonesIds[] = substr($zone, 1);
        $aZonesIdsHash[substr($zone, 1)] = "x";
    }
}

switch ($action) {
    case "link" :
            $result = $oDalZones->linkZonesToCampaign($aZonesIds, $campaignId);
        break;
    case "unlink" :
            $result = $oDalZones->unlinkZonesFromCampaign($aZonesIds, $campaignId);
        break;
};

$oTpl = new OA_Admin_Template('campaign-zone-zones.html');

// Available zones go here
$availableWebsites = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $_REQUEST['category-available'], $campaignId, false, $_REQUEST['text-available']);
$aAvailableZones = array (
    'all'     => $oDalZones->countZones($agencyId, null, $campaignId, false),
    'showing' => $oDalZones->countZones($agencyId, $_REQUEST['category-available'], $campaignId, false, $_REQUEST['text-available'])
);
$oTpl->assign('websites', $availableWebsites);
$oTpl->assign('zonescounts',  $aAvailableZones);
$oTpl->assign('category', $_REQUEST['category-available-text']);
$oTpl->assign('text', $_REQUEST['text-available']);
$oTpl->assign('status', "available");
$oTpl->assign('aZonesIdHash', $aZonesIdsHash);
$oTpl->display();

// Linked zones go here
$linkedWebsites = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $_REQUEST['category-linked'], $campaignId, true, $_REQUEST['text-linked']);
$aLinkedZones = array (
    'all'     => $oDalZones->countZones($agencyId, null, $campaignId, true),
    'showing' => $oDalZones->countZones($agencyId, $_REQUEST['category-linked'], $campaignId, true, $_REQUEST['text-linked'])
);
$oTpl->assign('websites', $linkedWebsites);
$oTpl->assign('zonescounts',  $aLinkedZones);
$oTpl->assign('category', $_REQUEST['category-linked-text']);
$oTpl->assign('text', $_REQUEST['text-linked']);
$oTpl->assign('status', "linked");
$oTpl->assign('aZonesIdHash', $aZonesIdsHash);
$oTpl->display();

echo "<div class='result-info'>";
switch ($action) {
    case "link" :
            if ($result == -1) {
                echo $GLOBALS['strLinkingZonesProblem'];
            } else {
                echo $result." ".$GLOBALS['strZonesLinked'];
            }
        break;
    case "unlink" :
            if ($result == -1) {
                echo $GLOBALS['strUnlinkingZonesProblem'];
            } else {
                echo $result." ".$GLOBALS['strZonesUnlinked'];
            }
        break;
};
echo "</div>";

?>
<!-- ajax-response-mark -->
