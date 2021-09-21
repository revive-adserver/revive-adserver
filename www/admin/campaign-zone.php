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
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OX/Admin/UI/ViewHooks.php';

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$advertiserId = MAX_getValue('clientid');
$campaignId = MAX_getValue('campaignid');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid, false, OA_Permission::OPERATION_VIEW);
OA_Permission::enforceAccessToObject('campaigns', $campaignid, true, OA_Permission::OPERATION_EDIT);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();

$agencyId = OA_Permission::getAgencyId();
$aOtherAdvertisers = Admin_DA::getAdvertisers(['agency_id' => $agencyId]);
$aOtherCampaigns = Admin_DA::getPlacements(['advertiser_id' => $advertiserId]);
$pageName = basename($_SERVER['SCRIPT_NAME']);
$aEntities = ['clientid' => $advertiserId, 'campaignid' => $campaignId];
MAX_displayNavigationCampaign($campaignId, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('campaign-zone.html');

$oDalZones = OA_Dal::factoryDAL('zones');
$linkedWebsites = $oDalZones->getWebsitesAndZonesList($agencyId, $campaignId, true);
$availableWebsites = $oDalZones->getWebsitesAndZonesList($agencyId, $campaignId, false);

/** add view hooks **/
OX_Admin_UI_ViewHooks::registerPageView(
    $oTpl,
    'campaign-zone',
    ['advertiserId' => $advertiserId, 'campaignId' => $campaignId]
);


$oTpl->assign('advertiserId', $advertiserId);
$oTpl->assign('campaignId', $campaignId);

$oTpl->assign('runMPE', $GLOBALS['_MAX']['CONF']['priority']['instantUpdate']);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();
