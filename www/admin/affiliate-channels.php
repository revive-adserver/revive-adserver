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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';


// Register input variables
phpAds_registerGlobal ('acl', 'action', 'submit');


/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
if (!empty($affiliateid) && !OA_Permission::hasAccessToObject('affiliates', $affiliateid)) { //check if can see given website
    $page = basename($_SERVER['SCRIPT_NAME']);
    OX_Admin_Redirect::redirect($page);
}

/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/
//get websites and set the current one
$aWebsites = getWebsiteMap();
if (empty($affiliateid)) { //if it's empty
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid']) {
        //try previous one from session
        $sessionWebsiteId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'];
        if (isset($aWebsites[$sessionWebsiteId])) { //check if 'id' from session was not removed
            $affiliateid = $sessionWebsiteId;
        }
    }
    if (empty($affiliateid)) { //was empty, is still empty - just pick one, no need for redirect
        $ids = array_keys($aWebsites);
        $affiliateid = !empty($ids) ? $ids[0] : -1; //if no websites set to non-existent id
    }
}
else {
    if (!isset($aWebsites[$affiliateid])) { //bad id, redirect
        $page = basename($_SERVER['SCRIPT_NAME']);
        OX_Admin_Redirect::redirect($page);
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oHeaderModel = buildHeaderModel($affiliateid);
phpAds_PageHeader(null, $oHeaderModel);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('channel-index.html');

$channels = Admin_DA::getChannels(array('publisher_id' => $affiliateid), true);
$aChannels = array();
foreach ($channels as $channelId => $channel) {
	$aChannels[$channelId] = $channel;
}

$oTpl->assign('aChannels', $aChannels);
$oTpl->assign('entityUrl', 'affiliate-channels.php');
$oTpl->assign('entityId', 'affiliateid=' . $affiliateid);
$oTpl->assign('affiliateId', $affiliateid);


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();
phpAds_PageFooter();


function buildHeaderModel($websiteId)
{
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    if ($doAffiliates->get($websiteId)) {
        $aWebsite = $doAffiliates->toArray();
    }

    $websiteName = $aWebsite['name'];
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
        $websiteEditUrl = "affiliate-edit.php?affiliateid=$websiteId";
    }

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array(
        array ('name' => $websiteName, 'url' => $websiteEditUrl,
               'id' => $websiteId, 'entities' => getWebsiteMap(),
               'htmlName' => 'affiliateid'
              ),
        array('name' => '')
    ), 'channels', 'list');

    return $oHeaderModel;
}


function getWebsiteMap()
{
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) { //should this constraint be added always instead of only for managers?
        $doAffiliates->agencyid = OA_Permission::getAgencyId();
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
        $doAffiliates->agencyid = OA_Permission::getEntityId();
    }
    $doAffiliates->addSessionListOrderBy($sortPageName);
    $doAffiliates->find();

    $aWebsiteMap = array();
    while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
        $aWebsiteMap[$row['affiliateid']] = array('name' => $row['name'],
            'url' => "affiliate-edit.php?affiliateid=".$row['affiliateid']);
    }

    return $aWebsiteMap;
}

?>
