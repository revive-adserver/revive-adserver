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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OX/Translation.php';

require_once RV_PATH . '/lib/RV/Admin/DateTimeFormat.php';

// Register input variables
phpAds_registerGlobal('hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (!empty($clientid) && !OA_Permission::hasAccessToObject('clients', $clientid)) { //check if can see given advertiser
    $page = basename($_SERVER['SCRIPT_NAME']);
    OX_Admin_Redirect::redirect($page);
}
if (!empty($campaignid) && !OA_Permission::hasAccessToObject('campaigns', $campaignid)) {
    $page = basename($_SERVER['SCRIPT_NAME']);
    OX_Admin_Redirect::redirect("$page?clientid=$clientid");
}


/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/

//get advertisers and set the current one
$aAdvertisers = getAdvertiserMap();
if (empty($clientid)) { //if it's empty
    $campaignid = null; //reset campaign id, we could derive it after we have clientid
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid']) {
        //try previous one from session
        $sessionClientId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];
        if (isset($aAdvertisers[$sessionClientId])) { //check if 'id' from session was not removed
            $clientid = $sessionClientId;
        }
    }
    if (empty($clientid)) { //was empty, is still empty - just pick one, no need for redirect
        $ids = array_keys($aAdvertisers);
        if (!empty($ids)) {
            $clientid = $ids[0];
        } else {
            $clientid = -1; //if no advertisers set to non-existent id
            $campaignid = -1; //also reset campaign id
        }
    }
} else {
    if (!isset($aAdvertisers[$clientid])) {
        $page = basename($_SERVER['SCRIPT_NAME']);
        OX_Admin_Redirect::redirect($page);
    }
}

//get campaigns - if there was any client id derived
if ($clientid > 0) {
    $aCampaigns = getCampaignMap($clientid);
    if (empty($campaignid)) { //if it's empty
        if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid]) {
            //try previous one from session
            $sessionCampaignId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid];
            if (isset($aCampaigns[$sessionCampaignId])) { //check if 'id' from session was not removed
                $campaignid = $sessionCampaignId;
            }
        }
        if (empty($campaignid)) { //was empty, is still empty - just pick one, no need for redirect
            $ids = array_keys($aCampaigns);
            $campaignid = !empty($ids) ? $ids[0] : -1; //if no campaigns set to non-existent id
        }
    } else {
        if (!isset($aCampaigns[$campaignid])) {
            $page = basename($_SERVER['SCRIPT_NAME']);
            OX_Admin_Redirect::redirect("$page?clientid=$clientid");
        }
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = ['clientid' => $clientid, 'campaignid' => $campaignid];
$oTrans = new OX_Translation();

// Display navigation
$aOtherAdvertisers = Admin_DA::getAdvertisers(['agency_id' => $agencyId]);
$aOtherCampaigns = Admin_DA::getPlacements(['advertiser_id' => $clientid]);

$oHeaderModel = buildHeaderModel($aEntities);
phpAds_PageHeader(null, $oHeaderModel);


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['hideinactive'])) {
        $hideinactive = $session['prefs']['campaign-banners.php'][$campaignid]['hideinactive'];
    } else {
        $pref = &$GLOBALS['_MAX']['PREF'];
        $hideinactive = ($pref['ui_hide_inactive'] == true);
    }
}

if (!isset($listorder)) {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['listorder'])) {
        $listorder = $session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'])) {
        $orderdirection = $session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
    } else {
        $orderdirection = '';
    }
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('banner-index.html');


$doBanners = OA_Dal::factoryDO('banners');
$doBanners->campaignid = $campaignid;
$doBanners->addListorderBy($listorder, $orderdirection);
$doBanners->selectAdd('storagetype AS type');
$doBanners->selectAdd('updated AS updated');
$doBanners->find();

$countActive = 0;

while ($doBanners->fetch() && $row = $doBanners->toArray()) {
    $banners[$row['bannerid']] = $row;
    $banners[$row['bannerid']]['active'] = $banners[$row['bannerid']]["status"] == OA_ENTITY_STATUS_RUNNING;

    $banners[$row['bannerid']]['description'] = $strUntitled;
    if (isset($banners[$row['bannerid']]['alt']) && $banners[$row['bannerid']]['alt'] != '') {
        $banners[$row['bannerid']]['description'] = $banners[$row['bannerid']]['alt'];
    }

    // mask banner name if anonymous campaign
    $campaign_details = Admin_DA::getPlacement($row['campaignid']);
    $campaignAnonymous = $campaign_details['anonymous'] == 't' ? true : false;
    $banners[$row['bannerid']]['description'] = MAX_getAdName($row['description'], null, null, $campaignAnonymous, $row['bannerid']);

    $banners[$row['bannerid']]['expand'] = 0;
    if ($row['status'] == OA_ENTITY_STATUS_RUNNING) {
        $countActive++;
    }

    // Build banner preview
    if ($row['bannerid'] && !empty($GLOBALS['_MAX']['PREF']['ui_show_campaign_preview']) && empty($_GET['nopreview'])) {
        $bannerCode = MAX_bannerPreview($row['bannerid']);
    } else {
        $bannerCode = '';
    }
    $banners[$row['bannerid']]['preview'] = $bannerCode;
}

$aCount = [
    'banners' => 0,
    'banners_hidden' => 0,
];


// Figure out which banners are inactive and prepare trimmed URLs for display
$bannersHidden = 0;
if (isset($banners) && is_array($banners) && count($banners) > 0) {
    reset($banners);
    foreach ($banners as $key => $banner) {
        $aCount['banners']++;
        if (($hideinactive == true) && ($banner['status'] != OA_ENTITY_STATUS_RUNNING)) {
            $bannersHidden++;
            $aCount['banners_hidden']++;
            unset($banners[$key]);
        } elseif (strlen($banner['url']) > 40) {
            $banners[$key]['url_trimmed'] = substr_replace($banner['url'], ' ...', 40);
        }
    }
} else {
    $banners = [];
}

$oTpl->assign('clientId', $clientid);
$oTpl->assign('campaignId', $campaignid);
$oTpl->assign('aBanners', $banners);
$oTpl->assign('aCount', $aCount);
$oTpl->assign('hideinactive', $hideinactive);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('isManager', OA_Permission::isAccount(OA_ACCOUNT_MANAGER));

$isAdvertiser = OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER);

$oTpl->assign('canAdd', !$isAdvertiser);
$oTpl->assign('canACL', !$isAdvertiser);
$oTpl->assign('canEdit', !$isAdvertiser || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT));
$oTpl->assign('canActivate', !$isAdvertiser || OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE));
$oTpl->assign('canDeactivate', !$isAdvertiser || OA_Permission::hasPermission(OA_PERM_BANNER_DEACTIVATE));
$oTpl->assign('canDelete', !$isAdvertiser && OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE));


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['campaign-banners.php'][$campaignid]['hideinactive'] = $hideinactive;
$session['prefs']['campaign-banners.php'][$campaignid]['listorder'] = $listorder;
$session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'] = $orderdirection;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();

phpAds_PageFooter();

function buildHeaderModel($aEntities)
{
    global $phpAds_TextDirection;
    $aConf = $GLOBALS['_MAX']['CONF'];

    $advertiserId = $aEntities['clientid'];
    $campaignId = $aEntities['campaignid'];
    $agencyId = OA_Permission::getAgencyId();

    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['campaignid']);
    $otherEntityString = _getEntityString($aOtherEntities);

    $advertiser = phpAds_getClientDetails($advertiserId);
    $advertiserName = $advertiser ['clientname'];
    $campaignDetails = Admin_DA::getPlacement($campaignId);
    $campaignName = $campaignDetails['name'];
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $campaignEditUrl = "campaign-edit.php?clientid=$advertiserId&campaignid=$campaignId";
    }

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader([
        ['name' => $advertiserName, 'url' => '',
               'id' => $advertiserId, 'entities' => getAdvertiserMap($agencyId),
               'htmlName' => 'clientid'
              ],
        ['name' => $campaignName, 'url' => $campaignEditUrl,
               'id' => $campaignId, 'entities' => getCampaignMap($advertiserId),
               'htmlName' => 'campaignid'
              ],
        ['name' => '']
    ], 'banners', 'list');

    return $oHeaderModel;
}


function getAdvertiserMap()
{
    $aAdvertisers = [];
    $dalClients = OA_Dal::factoryDAL('clients');
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $agency_id = OA_Permission::getEntityId();
        $aAdvertisers = $dalClients->getAllAdvertisersForAgency($agency_id);
    } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $advertiserId = OA_Permission::getEntityId();
        $aAdvertiser = $dalClients->getAdvertiserDetails($advertiserId);
        $aAdvertisers[$advertiserId] = $aAdvertiser;
    }

    //TODO do we need to filter out system entities here, or will the DAO do that?
    $aAdvertiserMap = [];
    foreach ($aAdvertisers as $clientid => $aClient) {
        $aAdvertiserMap[$clientid] = ['name' => $aClient['clientname'],
            'url' => "advertiser-campaigns.php?clientid=" . $clientid];
    }

    return $aAdvertiserMap;
}


function getCampaignMap($advertiserId)
{
    $aCampaigns = Admin_DA::getPlacements(['advertiser_id' => $advertiserId]);

    $aCampaignMap = [];
    foreach ($aCampaigns as $campaignId => $aCampaign) {
        $campaignName = $aCampaign['name'];
        // mask campaign name if anonymous campaign
        $campaign_details = Admin_DA::getPlacement($campaignId);
        $campaignName = MAX_getPlacementName($campaign_details);
        $aCampaignMap[$campaignId] = ['name' => $campaignName];
    }

    return $aCampaignMap;
}
