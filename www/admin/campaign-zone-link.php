<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Send header with charset info
header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));

require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/CampaignZoneLink.php';

phpAds_registerGlobalUnslashed('action', 'campaignid', 'allSelected',
        'text-linked', 'text-available');

$agencyId   = OA_Permission::getAgencyId();
$oDalZones  = OA_Dal::factoryDAL('zones');
$action     = $GLOBALS["action"];
$campaignId = $GLOBALS['campaignid'];

OA_Permission::enforceAccount ( OA_ACCOUNT_MANAGER );
OA_Permission::enforceAccessToObject ( 'campaigns', $campaignid );

OA_Permission::checkSessionToken();

$aZonesIds = array();
$aZonesIdsHash = array();
foreach ($_REQUEST['ids'] as $zone) {
    if (substr($zone, 0, 1) == 'z') {
        $aZonesIds[] = (int) substr($zone, 1);
        $aZonesIdsHash[(int) substr($zone, 1)] = "x";
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
    $link = ($action == 'link');
    $text = ($link ? $GLOBALS['text-available'] : $GLOBALS['text-linked']);
    $websites = $oDalZones->getWebsitesAndZones($agencyId, $campaignId, !$link, $text);
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

// CSRF Token
echo "<!--token-value-start-->".phpAds_SessionGetToken()."<!--token-value-end-->";
