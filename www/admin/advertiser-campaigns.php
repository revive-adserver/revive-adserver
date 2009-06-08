<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/max/other/html.php';

phpAds_registerGlobalUnslashed('hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (!empty($clientid) && !OA_Permission::hasAccessToObject('clients', $clientid)) { //check if can see given advertiser
    $page = basename($_SERVER['PHP_SELF']);
    OX_Admin_Redirect::redirect($page);
}


/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/
//get advertisers and set the current one
$aAdvertisers = getAdvertiserMap();
if (empty($clientid)) { //if it's empty
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid']) {
        //try previous one from session
        $sessionClientId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];
        if (isset($aAdvertisers[$sessionClientId])) { //check if 'id' from session was not removed
            $clientid = $sessionClientId;
        }
    }
    if (empty($clientid)) { //was empty, is still empty - just pick one, no need for redirect
        $ids = array_keys($aAdvertisers);
        $clientid = !empty($ids) ? $ids[0] : -1; //if no advertisers set to non-existent id
    }
}
else {
    if (!isset($aAdvertisers[$clientid])) {
        $page = basename($_SERVER['PHP_SELF']);
        OX_Admin_Redirect::redirect($page);
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oHeaderModel = buildHeaderModel($clientid, $aAdvertisers);
phpAds_PageHeader(null, $oHeaderModel);


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
	if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'])) {
		$hideinactive = $session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'];
	} else {
	   $pref = &$GLOBALS['_MAX']['PREF'];
	   $hideinactive = ($pref['ui_hide_inactive'] == true);
	}
}

if (!isset($listorder)) {
	if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'])) {
		$listorder = $session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'];
	} else {
		$listorder = '';
	}
}

if (!isset($orderdirection)) {
	if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'])) {
		$orderdirection = $session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'];
	} else {
		$orderdirection = '';
	}
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('campaign-index.html');


// Get clients & campaign and build the tree
$doCampaigns = OA_Dal::factoryDO('campaigns');
$doCampaigns->clientid = $clientid;

$doCampaigns->addListOrderBy($listorder, $orderdirection);
$doCampaigns->find();

while ($doCampaigns->fetch() && $row_campaigns = $doCampaigns->toArray()) {
	$campaigns[$row_campaigns['campaignid']]['campaignid']   = $row_campaigns['campaignid'];

    // mask campaign name if anonymous campaign
    $campaign_details = Admin_DA::getPlacement($row_campaigns['campaignid']);
    $row_campaigns['campaignname'] = MAX_getPlacementName($campaign_details);

	$campaigns[$row_campaigns['campaignid']]['campaignname'] = $row_campaigns['campaignname'];
	$campaigns[$row_campaigns['campaignid']]['impressions']  = phpAds_formatNumber($row_campaigns['views']);
	$campaigns[$row_campaigns['campaignid']]['clicks']       = phpAds_formatNumber($row_campaigns['clicks']);
	$campaigns[$row_campaigns['campaignid']]['conversions']  = phpAds_formatNumber($row_campaigns['conversions']);
	if (($row_campaigns['activate']) && ($row_campaigns['activate'] != '0000-00-00')) {
	   $oActivateDate = new Date($row_campaigns['activate']);
	   $campaigns[$row_campaigns['campaignid']]['activate']  = $oActivateDate->format($date_format);
    } else {
       $campaigns[$row_campaigns['campaignid']]['activate']  = '-';
    }
	if (($row_campaigns['activate']) && ($row_campaigns['expire'] != '0000-00-00')) {
	   $oExpireDate = new Date($row_campaigns['expire']);
	   $campaigns[$row_campaigns['campaignid']]['expire']    = $oExpireDate->format($date_format);
    } else {
       $campaigns[$row_campaigns['campaignid']]['expire']    = '-';
    }
    if ($row_campaigns['priority'] == -1) {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strExclusive;
    } elseif ($row_campaigns['priority'] == -2) {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strCampaignECPM;
    } elseif ($row_campaigns['priority'] == 0) {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strLow;
    } else {
        $campaigns[$row_campaigns['campaignid']]['priority'] = $strHigh . ' (' . $row_campaigns['priority'] . ')';
    }
	$campaigns[$row_campaigns['campaignid']]['status'] = $row_campaigns['status'];
    $campaigns[$row_campaigns['campaignid']]['anonymous'] = $row_campaigns['anonymous'];
    $campaigns[$row_campaigns['campaignid']]['type'] = OX_Util_Utils::getCampaignType($row_campaigns['priority']);
}

$aCount = array(
    'campaigns'        => 0,
    'campaigns_hidden' => 0,
);

$campaignshidden = 0;
if (isset($campaigns) && is_array($campaigns) && count($campaigns) > 0) {
	reset ($campaigns);
	while (list ($key, $campaign) = each ($campaigns)) {
		$aCount['campaigns']++;
		if ($hideinactive == true && ($campaign['status'] != OA_ENTITY_STATUS_RUNNING || $campaign['status'] == OA_ENTITY_STATUS_RUNNING &&
			count($campaign['banners']) == 0 && count($campaign['banners']) < $campaign['count'])) {
			$aCount['campaigns_hidden']++;
			unset($campaigns[$key]);
		}
	}
}

$oTpl->assign('clientId', $clientid);
$oTpl->assign('aCampaigns', $campaigns);
$oTpl->assign('aCount', $aCount);
$oTpl->assign('hideinactive', $hideinactive);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('showconversions', $conf['logging']['trackerImpressions']);
$oTpl->assign('isAdvertiser', OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER));
$oTpl->assign('canEdit', OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT));
$oTpl->assign('isManager', OA_Permission::isAccount(OA_ACCOUNT_MANAGER));


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'] = $hideinactive;
$session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'] = $listorder;
$session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'] = $orderdirection;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();
phpAds_PageFooter();



function buildHeaderModel($advertiserId, $aAllAdvertisers)
{
    if ($advertiserId) {
        $advertiser = phpAds_getClientDetails ($advertiserId);
        $advertiserName = $advertiser ['clientname'];
        $advertiserEditUrl = "advertiser-edit.php?clientid=$advertiserId";
    }
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array(
        array ('name' => $advertiserName, 'url' => $advertiserEditUrl,
               'id' => $advertiserId, 'entities' => $aAllAdvertisers,
               'htmlName' => 'clientid'
              ),
        array('name' => '')
    ), 'campaigns', 'list');

    return $oHeaderModel;
}


function getAdvertiserMap()
{
    $doClients = OA_Dal::factoryDO('clients');
    // Unless admin, restrict results shown.
    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $doClients->clientid = OA_Permission::getEntityId();
    }
    else {
        $doClients->agencyid = OA_Permission::getEntityId();
    }
    //$doClients->addSessionListOrderBy('advertiser-index.php');
    $doClients->find();

    $aAdvertiserMap = array();
    while ($doClients->fetch() && $row = $doClients->toArray()) {
        $aAdvertiserMap[$row['clientid']] = array('name' => $row['clientname'],
            'url' => "advertiser-campaigns.php?clientid=".$row['clientid']);
    }

    return $aAdvertiserMap;
}


?>
