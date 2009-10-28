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
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OX/Admin/UI/ViewHooks.php';

phpAds_registerGlobalUnslashed('hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (!empty($clientid) && !OA_Permission::hasAccessToObject('clients', $clientid, OA_Permission::OPERATION_VIEW)) { //check if can see given advertiser
    $page = basename($_SERVER['SCRIPT_NAME']);
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
        $page = basename($_SERVER['SCRIPT_NAME']);
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
$dalCampaigns = OA_Dal::factoryDAL('campaigns');
$aCampaigns = $dalCampaigns->getClientCampaigns($clientid, $listorder, $orderdirection, array(DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT));
foreach ($aCampaigns as $campaignId => $aCampaign) {
    $aCampaign['impressions']  = phpAds_formatNumber($aCampaign['views']);
    $aCampaign['clicks']       = phpAds_formatNumber($aCampaign['clicks']);
    $aCampaign['conversions']  = phpAds_formatNumber($aCampaign['conversions']);
  
    if (!empty($aCampaign['activate_time'])) {
        $oActivateDate = new Date($aCampaign['activate_time']);
        $oTz = $oActivateDate->tz;
        $oActivateDate->setTZbyID('UTC');
        $oActivateDate->convertTZ($oTz);
        $aCampaign['activate']  = $oActivateDate->format($date_format);
    } 
    else {
        $aCampaign['activate']  = '-';
    }
    
    if (!empty($aCampaign['expire_time'])) {
        $oExpireDate = new Date($aCampaign['expire_time']);
        $oTz = $oExpireDate->tz;
        $oExpireDate->setTZbyID('UTC');
        $oExpireDate->convertTZ($oTz);
        $aCampaign['expire']    = $oExpireDate->format($date_format);
    } 
    else {
        $aCampaign['expire']    = '-';
    }
    if ($row_campaigns['priority'] == -1) {
        $aCampaign['priority'] = $strExclusive;
    } 
    elseif ($row_campaigns['priority'] == -2) {
        $aCampaign['priority'] = $strCampaignECPM;
    } 
    elseif ($row_campaigns['priority'] == 0) {
        $aCampaign['priority'] = $strLow;
    } 
    else {
        $aCampaign['priority'] = $strHigh . ' (' . $row_campaigns['priority'] . ')';
    }
    
    if ($aCampaign['type'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT) {
        $aCampaign['system'] = true;
        $oComponent = OX_Component::factory('admin', 'oxMarket', 'oxMarket');
        if ($oComponent) {           
            $aCampaign['type'] = $oComponent->getEntityHelper()->getCampaignTypeName($aCampaign);
        }
        else {
            $aCampaign['type'] = OX_Util_Utils::getCampaignType($aCampaign['priority']);            
        }
    }
    else {
        $aCampaign['type'] = OX_Util_Utils::getCampaignType($aCampaign['priority']);
    }
    
    
    $aCampaigns[$campaignId] = $aCampaign; 
}

$aCount = array(
    'campaigns'        => 0,
    'campaigns_hidden' => 0,
);

$campaignshidden = 0;
if (isset($aCampaigns) && is_array($aCampaigns) && count($aCampaigns) > 0) {
	reset ($aCampaigns);
	while (list ($key, $campaign) = each ($aCampaigns)) {
		$aCount['campaigns']++;
		if ($hideinactive == true && ($campaign['status'] != OA_ENTITY_STATUS_RUNNING || $campaign['status'] == OA_ENTITY_STATUS_RUNNING &&
			count($campaign['banners']) == 0 && count($campaign['banners']) < $campaign['count'])) {
			$aCount['campaigns_hidden']++;
			unset($aCampaigns[$key]);
		}
	}
}


$oTpl->assign('clientId', $clientid);
$oTpl->assign('aCampaigns', $aCampaigns);
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
/** add view hooks **/
OX_Admin_UI_ViewHooks::registerPageView($oTpl, 'advertiser-campaigns', 
    array('advertiserId' => $clientid));

$oTpl->display();
phpAds_PageFooter();



function buildHeaderModel($advertiserId, $aAllAdvertisers)
{
    if ($advertiserId) {
        $advertiser = phpAds_getClientDetails ($advertiserId);
        
        $advertiserName = $advertiser ['clientname'];
        if ($advertiser['type'] != DataObjects_Clients::ADVERTISER_TYPE_MARKET) {
            $advertiserEditUrl = "advertiser-edit.php?clientid=$advertiserId";
        }
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
    $aAdvertisers = array();
    $dalClients = OA_Dal::factoryDAL('clients');
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $agency_id = OA_Permission::getEntityId();
        $oComponent = &OX_Component::factory ( 'admin', 'oxMarket', 'oxMarket');
        $aInludeSystemTypes = array();
        //TODO well, hardcoded reference to market plugin again, it would be better
        //to ask plugins for additional types to include via hook.
        if (isset($oComponent) && $oComponent->enabled && $oComponent->isActive()) {
            $aInludeSystemTypes = array(DataObjects_Clients::ADVERTISER_TYPE_MARKET);
        }
        $aAdvertisers = $dalClients->getAllAdvertisersForAgency($agency_id, 
            null, null, $aInludeSystemTypes);
    }
    else if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $advertiserId = OA_Permission::getEntityId();
        $aAdvertiser = $dalClients->getAdvertiserDetails($advertiserId);
        $aAdvertisers[$advertiserId] = $aAdvertiser;
    }
        
    $aAdvertiserMap = array();
    foreach ($aAdvertisers as $clientid => $aClient) {
        $aAdvertiserMap[$clientid] = array('name' => $aClient['clientname'],
            'url' => "advertiser-campaigns.php?clientid=".$clientid);
    }

    return $aAdvertiserMap;
}


?>
