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


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/CampaignZoneLink.php';

phpAds_registerGlobalUnslashed('action', 'campaignid', 'allSelected');

$agencyId   = OA_Permission::getAgencyId();
$oDalZones  = OA_Dal::factoryDAL('zones');
$action     = $GLOBALS["action"];
$campaignId = $GLOBALS['campaignid'];

OA_Permission::enforceAccount ( OA_ACCOUNT_MANAGER );
OA_Permission::enforceAccessToObject ( 'campaigns', $campaignid );

$aZonesIds = array();
$aZonesIdsHash = array();
foreach ($_REQUEST['ids'] as $zone) {
    if (substr($zone, 0, 1) == 'z') {
        $aZonesIds[] = substr($zone, 1);
        $aZonesIdsHash[substr($zone, 1)] = "x";
    }
}

// If we're requested to link all matching zones, we need to determine the ids to link
// Ideally, there should be a DAL method to that directly. Note that we're replacing
// only the $aZonesIds array here, and keeping $aZonesIdsHash populated based on the
// zone ids from the request. This way, zones with ids from the request will get
// higlighted as "just linked". It doesn't make to put all zone ids in $aZonesIdsHash as 
// only 
if ($GLOBALS['allSelected'] == 'true') {
    $aZonesIds = array();
    $websites = $oDalZones->getWebsitesAndZonesListByCategory($agencyId, $category, $campaignId, $linked, $text);
    foreach ($websites as $website) {
        $zones = $website['zones'];
        foreach ($zones as $zoneid => $zone) {
        	$aZonesIds []= $zoneid;
        }
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

$oTpl = OA_Admin_UI_CampaignZoneLink::createTemplateWithModel('available', false);
$oTpl->assign('aZonesIdHash', $aZonesIdsHash);
$oTpl->display();

$oTpl = OA_Admin_UI_CampaignZoneLink::createTemplateWithModel('linked', false);
$oTpl->assign('aZonesIdHash', $aZonesIdsHash);
$oTpl->display();

// We need to
echo "<!--result-info-start-->";
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
echo "<!--result-info-end-->";

?>
