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
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/NumberFormat.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/UI/CampaignForm.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Dal/Campaign.php';

// Register input variables
phpAds_registerGlobalUnslashed('start', 'startSet', 'anonymous', 'campaignname', 'clicks', 'companion', 'comments', 'conversions', 'end', 'endSet', 'priority', 'high_priority_value', 'revenue', 'revenue_type', 'submit', 'submit_status', 'target_old', 'target_type_old', 'target_value', 'target_type', 'rd_impr_bkd', 'rd_click_bkd', 'rd_conv_bkd', 'impressions', 'weight_old', 'weight', 'clientid', 'status', 'status_old', 'as_reject_reason', 'an_status', 'previousimpressions', 'previousconversions', 'previousclicks');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER );
OA_Permission::enforceAccessToObject('clients', $clientid, false, OA_Permission::OPERATION_VIEW);
OA_Permission::enforceAccessToObject('campaigns', $campaignid, true, OA_Permission::OPERATION_EDIT);


// Security check
$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
$oMarketComponent->checkActive();

/*-------------------------------------------------------*/
/* Initialise data                                    */
/*-------------------------------------------------------*/
if ($campaignid != "") {
    // Get the campaign data from the campaign table, and store in $aCampaign
    $doCampaigns = OA_Dal::factoryDO('campaigns');
    $doCampaigns->selectAdd("views AS impressions");
    $doCampaigns->get($campaignid);
    $data = $doCampaigns->toArray();
    
    $aCampaign['campaignname'] = $data['campaignname'];
    $aCampaign['impressions'] = $data['impressions'];
    $aCampaign['clicks'] = $data['clicks'];
    $aCampaign['conversions'] = $data['conversions'];
    $aCampaign['expire'] = $data['expire'];
    if (!empty($data['expire_time'])) {
        $oExpireDate = new Date($data['expire_time']);
        $oTz = $oExpireDate->tz;
        $oExpireDate->setTZbyID('UTC');
        $oExpireDate->convertTZ($oTz);
        $aCampaign['expire_f'] = $oExpireDate->format($date_format);
        $aCampaign['expire_date'] = $oExpireDate->format('%Y-%m-%d');
    }
    $aCampaign['status'] = $doCampaigns->status;
    $aCampaign['an_status'] = $doCampaigns->an_status;
    $aCampaign['as_reject_reason'] = $doCampaigns->as_reject_reason;
    
    if (!empty($data['activate_time'])) {
        $oActivateDate = new Date($data['activate_time']);
        $oTz = $oActivateDate->tz;
        $oActivateDate->setTZbyID('UTC');
        $oActivateDate->convertTZ($oTz);
        $aCampaign['activate_f'] = $oActivateDate->format($date_format);
        $aCampaign['activate_date'] = $oActivateDate->format('%Y-%m-%d');
    }
    $aCampaign['priority'] = $data['priority'];
    $aCampaign['weight'] = $data['weight'];
    $aCampaign['target_impression'] = $data['target_impression'];
    $aCampaign['min_impressions'] = $data['min_impressions'];
    $aCampaign['ecpm'] = OA_Admin_NumberFormat::formatNumber($data['ecpm'], 4);
    $aCampaign['anonymous'] = $data['anonymous'];
    $aCampaign['companion'] = $data['companion'];
    $aCampaign['comments'] = $data['comments'];
    $aCampaign['revenue'] = OA_Admin_NumberFormat::formatNumber($data['revenue'], 4);
    $aCampaign['revenue_type'] = $data['revenue_type'];
    $aCampaign['block'] = $data['block'];
    $aCampaign['capping'] = $data['capping'];
    $aCampaign['session_capping'] = $data['session_capping'];
    $aCampaign['impressionsRemaining'] = '';
    $aCampaign['clicksRemaining'] = '';
    $aCampaign['conversionsRemaining'] = '';
    
    $aCampaign['impressionsRemaining'] = '';
    $aCampaign['clicksRemaining'] = '';
    $aCampaign['conversionsRemaining'] = '';
    
    // Get the campagin data from the data_intermediate_ad table, and store in $aCampaign
    if (($aCampaign['impressions'] > 0) || ($aCampaign['clicks'] > 0) || ($aCampaign['conversions'] > 0)) {
        $dalData_intermediate_ad = OA_Dal::factoryDAL('data_intermediate_ad');
        $record = $dalData_intermediate_ad->getDeliveredByCampaign($campaignid);
        $data = $record->toArray();
        
        if ($aCampaign['impressions'] != -1) {
            $aCampaign['impressionsRemaining'] = $aCampaign['impressions'] - $data['impressions_delivered'];
        }
        else {
            $aCampaign['impressionsRemaining'] = '';
        }
        if ($aCampaign['clicks'] != -1) {
            $aCampaign['clicksRemaining'] = $aCampaign['clicks'] - $data['clicks_delivered'];
        }
        else {
            $aCampaign['clicksRemaining'] = '';
        }
        if ($aCampaign['conversions'] != -1) {
            $aCampaign['conversionsRemaining'] = $aCampaign['conversions'] - $data['conversions_delivered'];
        }
        else {
            $aCampaign['conversionsRemaining'] = '';
        }
        $aCampaign['impressions_delivered'] = $data['impressions_delivered'];
        $aCampaign['clicks_delivered'] = $data['clicks_delivered'];
        $aCampaign['conversions_delivered'] = $data['conversions_delivered'];
        $deliveryDataLoaded = true;
    }
    
    // Get the value to be used in the target_value field
    if ($aCampaign['target_impression'] > 0) {
        $aCampaign['target_value'] = $aCampaign['target_impression'];
        $aCampaign['target_type'] = 'target_impression';
    }
    else {
        $aCampaign['target_value'] = '-';
        $aCampaign['target_type'] = 'target_impression';
    }
    
    if ($aCampaign['target_value'] > 0) {
        $aCampaign['weight'] = '-';
    }
    else {
        $aCampaign['target_value'] = '-';
    }
    
    if (!isset($aCampaign["activate_f"])) {
        $aCampaign["activate_f"] = "-";
    }
    
    if (!isset($aCampaign["expire_f"])) {
        $aCampaign["expire_f"] = "-";
    }
    
    // Set the default financial information
    if (!isset($aCampaign['revenue'])) {
        $aCampaign['revenue'] = OA_Admin_NumberFormat::formatNumber(0, 4);
    }
    
    // Set the default eCPM prioritization settings
    if (!isset($aCampaign['ecpm'])) {
        $aCampaign['ecpm'] = OA_Admin_NumberFormat::formatNumber(0, 4);
    }
}
else {
    // New campaign
    $doClients = OA_Dal::factoryDO('clients');
    $doClients->clientid = $clientid;
    $client = $doClients->toArray();
    
    if ($doClients->find() && $doClients->fetch() && $client = $doClients->toArray()) {
        $aCampaign['campaignname'] = $client['clientname'] . ' - ';
    }
    else {
        $aCampaign["campaignname"] = '';
    }
    
    $aCampaign["campaignname"] .= $strDefault . " " . $strCampaign;
    $aCampaign["impressions"] = -1;
    $aCampaign["clicks"] = -1;
    $aCampaign["conversions"] = -1;
    $aCampaign["status"] = (int) $status;
    $aCampaign["expire_time"] = '';
    $aCampaign["activate_time"] = '';
    $aCampaign["priority"] = 0;
    $aCampaign["anonymous"] = ($pref['gui_campaign_anonymous'] == 't') ? 't' : '';
    $aCampaign['revenue'] = '';
    $aCampaign['revenue_type'] = null;
    $aCampaign['target_value'] = '-';
    $aCampaign['impressionsRemaining'] = null;
    $aCampaign['clicksRemaining'] = null;
    $aCampaign['conversionsRemaining'] = null;
    $aCampaign['companion'] = null;
    $aCampaign['block'] = null;
    $aCampaign['capping'] = null;
    $aCampaign['session_capping'] = null;
    $aCampaign['comments'] = null;
    $aCampaign['target_type'] = null;
    $aCampaign['min_impressions'] = 100;
}

if ($aCampaign['status'] == OA_ENTITY_STATUS_RUNNING && OA_Dal::isValidDate($aCampaign['expire']) && $aCampaign['impressions'] > 0) {
    $aCampaign['delivery'] = 'auto';
}
elseif ($aCampaign['target_value'] > 0) {
    $aCampaign['delivery'] = 'manual';
}
else {
    $aCampaign['delivery'] = 'none';
}

$aCampaign['clientid'] = $clientid;
$aCampaign['campaignid'] = $campaignid;

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
//header
$oUI = OA_Admin_UI::getInstance();
$oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));

$oForm = new OX_oxMarket_UI_CampaignForm($oMarketComponent, $aCampaign);

if ($oForm->isSubmitted() && $oForm->validate()) {
    //process submitted values
    $errors = processCampaignForm($oForm, $oMarketComponent);
    if (!empty($errors)) { //need to redisplay page with general errors
        displayPage($aCampaign, $oForm, $oMarketComponent, $errors);
    }
}
else { //either validation failed or no form was not submitted, display the page
    displayPage($aCampaign, $oForm, $oMarketComponent);
}


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($aCampaign, $oForm, $oMarketComponent, $campaignErrors = null)
{
    $isNew = empty($aCampaign['campaignid']);
    
    //header and breadcrumbs
    if ($isNew) { //new campaign 
        $advertiser = phpAds_getClientDetails($aCampaign['clientid']);
        $advertiserName = $advertiser['clientname'];
        
        // New campaign
        $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
        $oHeaderModel = $builder->buildEntityHeader(array (
                array (
                        "name" => $advertiserName, 
                        "url" => null), 
                array ("name" => "")), "campaign", "edit-new");
        phpAds_PageHeader("market-campaign-edit_new", $oHeaderModel);
    }
    else { 
        //edit campaign
        // Initialise some parameters
        $agencyId = OA_Permission::getAgencyId();
        $aEntities = array ('clientid' => $aCampaign['clientid'], 
                'campaignid' => $aCampaign['campaignid']);
        
        // Display navigation
        $aOtherAdvertisers = Admin_DA::getAdvertisers(array (
                'agency_id' => $agencyId));
        $aOtherCampaigns = Admin_DA::getPlacements(array (
                'advertiser_id' => $aCampaign['clientid']));
        
        $advertiserId = $aCampaign['clientid'];
        $advertiserName = MAX_buildName($advertiserId, $aOtherAdvertisers[$advertiserId]['name']);
        
        addMarketCampaignPageTools($advertiserId, $aCampaign['campaignid']);
        
        $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
        $oHeaderModel = $builder->buildEntityHeader(array (
                array (
                        "name" => $advertiserName, 
                        "url" => null), 
                array (
                        "name" => $aCampaign['campaignname'])), "campaign", "edit");
        phpAds_PageHeader("market-campaign-edit", $oHeaderModel);
    }
    
    //get template and display form
    $oTpl = new OA_Plugin_Template('market-campaign-edit.html', 'oxMarket');
    $oTpl->assign('impressionsDelivered', isset($aCampaign['impressions_delivered']) ? $aCampaign['impressions_delivered'] : 0);
    $oTpl->assign('calendarBeginOfWeek', $GLOBALS['pref']['begin_of_week'] ? 1 : 0);
    $oTpl->assign('strCampaignWarningNoTargetMessage', str_replace("\n", '\n', addslashes($GLOBALS['strCampaignWarningNoTarget'])));
    $oTpl->assign('language', $GLOBALS['_MAX']['PREF']['language']);
    $oTpl->assign('campaignErrors', $campaignErrors);
    $oTpl->assign('isNew', $isNew);
    
    $aStrings = getCustomContent($oMarketComponent);
    $oTpl->assign('top', $aStrings['content_top']);
    $oTpl->assign('right', $aStrings['content_right']);
    $oTpl->assign('bottom', $aStrings['content_bottom']);
    
    $oTpl->assign('aBranding', $oMarketComponent->aBranding);
    
    $oTpl->assign('pluginVersion', $oMarketComponent->getPluginVersion());
    $oTpl->assign('form', $oForm->serialize());
    $oTpl->display();
    
    //footer
    phpAds_PageFooter();
}


function addMarketCampaignPageTools($clientid, $campaignid)
{
    global $phpAds_TextDirection;
    
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-modify.php?duplicate=1&clientid=$clientid&campaignid=$campaignid&returnurl=" . urlencode('plugins/oxMarket/'.basename($_SERVER['SCRIPT_NAME']))), "iconCampaignDuplicate");
        $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteCampaign']);
        addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-delete.php?clientid=$clientid&campaignid=$campaignid&returnurl=advertiser-campaigns.php"), "iconDelete", null, $deleteConfirm);
    }
    
    //shortcuts
    if (!empty($campaignid) && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        addPageShortcut($GLOBALS['strBackToCampaigns'], MAX::constructUrl(MAX_URL_ADMIN, "advertiser-campaigns.php?clientid=$clientid"), "iconBack");
        addPageShortcut($GLOBALS['strCampaignHistory'], MAX::constructUrl(MAX_URL_ADMIN, "stats.php?entity=campaign&breakdown=history&clientid=$clientid&campaignid=$campaignid"), 'iconStatistics');
    }
}


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
/**
 * Processes submit values of campaign form
 *
 * @param OA_Admin_UI_Component_Form $form form to process
 * @return An array of Pear::Error objects if any
 */
function processCampaignForm($form, &$oComponent)
{
    $aCampaign = $form->populateCampaign();
    
    $newCampaign = empty($aCampaign['campaignid']);
    
    $oCampaignDal = new OX_oxMarket_Dal_Campaign($oComponent);
    $aErrors = $oCampaignDal->saveCampaign($aCampaign);
    
    if (empty($aErrors)) {
        $translation = new OX_Translation();
        if ($newCampaign) {
            // Queue confirmation message
            $translated_message = $translation->translate($GLOBALS['strCampaignHasBeenNoBanner'], array (
                    MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/market-campaign-edit.php?clientid=' . $aCampaign['clientid'] . '&campaignid=' . $aCampaign['campaignid']), 
                    htmlspecialchars($aCampaign['campaignname']), 
                    MAX::constructURL(MAX_URL_ADMIN, 'banner-edit.php?clientid=' . $aCampaign['clientid'] . '&campaignid=' . $aCampaign['campaignid'])));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            OX_Admin_Redirect::redirect("advertiser-campaigns.php?clientid=" . $aCampaign['clientid']);
        }
        else {
            $translated_message = $translation->translate($GLOBALS['strCampaignHasBeenUpdated'], array (
                    MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/market-campaign-edit.php?clientid=' . $aCampaign['clientid'] . '&campaignid=' . $aCampaign['campaignid']), 
                    htmlspecialchars($aCampaign['campaignname'])));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            OX_Admin_Redirect::redirect("plugins/oxMarket/market-campaign-edit.php?clientid=" . $aCampaign['clientid'] . "&campaignid=" . $aCampaign['campaignid']);
        }
    }
    
    //return processing errors
    return $errors;
}

function getCustomContent($oMarketComponent)
{
    static $aContentStrings;

    if ($aContentStrings != null) {
        return $aContentStrings;
    }

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-campaign-edit');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }

    //get the custom content and fallback to hardcoded if not found
    $aContentStrings['content_top'] = isset($aContentKeys['content-top'])
        ? $aContentKeys['content-top']
        : '';
    $aContentStrings['content_right'] = isset($aContentKeys['content-right'])
        ? $aContentKeys['content-right']
        : '';
    $aContentStrings['content_bottom'] = isset($aContentKeys['content-bottom'])
        ? $aContentKeys['content-bottom']
        : '';
        
    return $aContentStrings;
}



?>
