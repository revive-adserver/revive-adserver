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

require_once 'market-common.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

// Register input variables
phpAds_registerGlobalUnslashed('acl', 'action', 'submit');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid, false, OA_Permission::OPERATION_VIEW);
OA_Permission::enforceAccessToObject('campaigns', $campaignid, false, OA_Permission::OPERATION_EDIT);

$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
//check if you can see this page
$oMarketComponent->checkActive();


// Initialise some parameters
$bannerid = getMarketBannerId($campaignid);
$tabindex = 1;
$aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid, 'bannerid' => $bannerid);

if (!empty($action)) {
    $acl = MAX_AclAdjust($acl, $action);
} 
elseif (!empty($submit)) {
    $acl = (isset($acl)) ? $acl : array();
    saveLimitations($aEntities, $acl);
}
displayPage($oMarketComponent, $aEntities, $acl);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($oMarketComponent, $aEntities, $acl)
{
    $advertiserId = $aEntities['clientid'];
    $campaignId = $aEntities['campaignid'];
    $bannerId = $aEntities['bannerid'];    
    
    // Display navigation
    $advertiserDetails = phpAds_getClientDetails($advertiserId);
    $advertiserName = $advertiserDetails['clientname'];
    $aCampaignDetails = Admin_DA::getPlacement($campaignId);
    
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array (
            array("name" => $advertiserName, 
                   "url" => null), 
            array("name" => $aCampaignDetails['name'])), "campaign", "edit");    
    

    addMarketCampaignPageTools($advertiserId, $campaignId);
    $oUI = OA_Admin_UI::getInstance();
    $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 
        'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));
    
    phpAds_PageHeader('market-campaign-acl', $oHeaderModel);
    
    
    /*-------------------------------------------------------*/
    /* Main code                                             */
    /*-------------------------------------------------------*/
    
    if (!isset($acl)) {
        $acl = Admin_DA::getDeliveryLimitations(array('ad_id' => $bannerId));
        // This array needs to be sorted by executionorder, this should ideally be done in SQL
        // When we move to DataObject this should be addressed
        ksort($acl);
    }
    $aParams = array('clientid' => $advertiserId, 'campaignid' => $campaignId, 'bannerid' => $bannerId);
    
    //MAX_displayAcls echoes delivery limitations table....
    ob_start();
    MAX_displayAcls($acl, $aParams);
    $limitationsForm = ob_get_clean();
    
    $oTpl = new OA_Plugin_Template('market-campaign-acl.html', 'oxMarket');
    $oTpl->assign('limitationsForm', $limitationsForm);
    $oTpl->display();
    
    phpAds_PageFooter();    
}


function saveLimitations($aEntities, $acl)
{
    $advertiserId = $aEntities['clientid'];
    $campaignId = $aEntities['campaignid'];
    $bannerId = $aEntities['bannerid'];
    
    
    // Only save when inputs are valid
    if (OX_AclCheckInputsFields($acl, 'market-campaign-acl.php') === true) {
        MAX_AclSave($acl, $aEntities);

        //
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerId);
        
        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate($GLOBALS['strBannerAclHasBeenUpdated'], 
            array("market-campaign-acl.php?clientid=".$advertiserId."&campaignid=".$campaignId, htmlspecialchars($doBanners->description)
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect("plugins/oxMarket/market-campaign-acl.php?clientid=".$advertiserId."&campaignid=".$campaignId);
    }
}


function addMarketCampaignPageTools($advertiserId, $campaignId)
{
    global $phpAds_TextDirection;
    
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-modify.php?duplicate=1&clientid=$advertiserId&campaignid=$campaignId&returnurl=" . urlencode(basename($_SERVER['SCRIPT_NAME']))), "iconCampaignDuplicate");
        $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteCampaign']);
        addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-delete.php?clientid=$advertiserId&campaignid=$campaignId&returnurl=advertiser-campaigns.php"), "iconDelete", null, $deleteConfirm);
    }
    
    //shortcuts
    if (!empty($campaignId) && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        addPageShortcut($GLOBALS['strBackToCampaigns'], MAX::constructUrl(MAX_URL_ADMIN, "advertiser-campaigns.php?clientid=$advertiserId"), "iconBack");
        addPageShortcut($GLOBALS['strCampaignHistory'], MAX::constructUrl(MAX_URL_ADMIN, "stats.php?entity=campaign&breakdown=history&clientid=$clientid&campaignid=$campaignid"), 'iconStatistics');
    }
}


function getMarketBannerId($campaignid)
{
    $bannerId = null;
    
    $dalBanners = OA_Dal::factoryDAL('banners');
    $aBanners = $dalBanners->getAllBannersUnderCampaign($campaignid, null, null, false);

    if (!empty($aBanners)) {
        $aBanner = array_shift($aBanners);
        $bannerId = $aBanner['bannerid'];
    }
    
    return $bannerId;
}

?>
