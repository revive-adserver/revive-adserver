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
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/rule/DecimalPlaces.php';
require_once MAX_PATH .'/lib/pear/HTML/QuickForm/Rule/Regex.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/rule/Max.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Dal/CampaignsOptIn.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
$oMarketComponent->checkActive();

if (!$oMarketComponent->isMarketSettingsAlreadyShown()) {
    $oMarketComponent->setMarketSettingsAlreadyShown();
}

$defaultMinCpm = $oMarketComponent->getConfigValue('defaultFloorPrice');
$maxCpm = $oMarketComponent->getMaxFloorPrice(); //used for validation purpose only

// Register some variables from the request
$request = phpAds_registerGlobalUnslashed('campaignType', 'toOptIn', 'minCpm', 'optedCount', 'search');
if (empty($campaignType)) {
    $campaignType = 'remnant';
}
if (!isset($minCpm)) {
    $minCpm = formatCpm($defaultMinCpm);
}

// Prepare DAL instance
$oCampaignsOptInDal = new OX_oxMarket_Dal_CampaignsOptIn();

$oTpl = new OA_Plugin_Template('market-campaigns-settings.html','openXMarket');

$minCpms = array();
foreach ($_REQUEST as $param => $value) {
    if (preg_match("/^cpm\d+$/", $param)) {
        $minCpms[substr($param, 3)] = $value;
    }
}

// Perform opt-in if needed
$campaigns = $oCampaignsOptInDal->getCampaigns($defaultMinCpm, $campaignType, $minCpms, $search);
if ('POST' == $_SERVER['REQUEST_METHOD']) { 
    if (isset($_REQUEST['opt-in-submit']) && isDataValid($oTpl, $campaigns, $maxCpm)) {
        performOptIn($minCpms, $oCampaignsOptInDal);
        exit(0);
    } 
    elseif (isset($_REQUEST['optout'])) {
        performOptOut($oCampaignsOptInDal);
        exit(0);
    }
}


$toOptIn = empty($toOptIn) ? array() : $toOptIn;


$itemsPerPage = 5;
$oPager = OX_buildPager($campaigns, $itemsPerPage);
$oTopPager = OX_buildPager($campaigns, $itemsPerPage, false);
list($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
$campaigns =  array_slice($campaigns, $itemsFrom - 1, $itemsPerPage, true);

$oTpl->assign('pager', $oPager);
$oTpl->assign('topPager', $oTopPager);


setupContentStrings($oMarketComponent, $oTpl, $optedCount);
$oTpl->assign('campaigns', $campaigns);
$oTpl->assign('campaignType', $campaignType);
$oTpl->assign('maxValueLength', 3 + strlen($maxCpm)); //two decimal places, point, plus strlen of maxCPM
$oTpl->assign('minCpms', $minCpms);
if ($_COOKIE['market-settings-info-box-hidden']) {
    $oTpl->assign('infoBoxHidden', true);
}
$firstView = empty($toOptIn);
$oTpl->assign('firstView', $firstView);

$toOptInMap = arrayValuesToKeys($toOptIn);
foreach ($campaigns as $campaignId => $campaign) {
	if (!isset($toOptInMap[$campaignId])) {
	    $toOptInMap[$campaignId] = $firstView;
	}
}
$oTpl->assign('toOptIn', $toOptInMap);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

//header
$oUI = OA_Admin_UI::getInstance();
$oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css'));
$oMenu = OA_Admin_Menu::singleton();

// Display the page
$oCurrentSection = $oMenu->get("market-campaigns-settings");
phpAds_PageHeader("market-campaigns-settings", new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName(), "iconMarketLarge"), '../../', true, true, true, false);

$oTpl->display();

//footer
phpAds_PageFooter();


function isDataValid($template, $aCampaigns, $maxCpmValue)
{
    global $toOptIn, $minCpm;
    $valid = true;
    $zero = false;
    $decimalValidator = new OA_Admin_UI_Rule_DecimalPlaces();
    $maxValidator = new OA_Admin_UI_Rule_Max();
    
    $invalidCpms = array();
    foreach ($toOptIn as $campaignId) {
        $value = $_REQUEST['cpm' . $campaignId];
        //is number
        $valueValid = is_numeric($value);
        
        $message = $valueValid ?  null : $message = getValidationMessage('format', $maxCpmValue);
        
        //is greater than zero
        if ($valueValid) {
            $valueValid = ($value > 0);
            $message = $valueValid ?  null : $message = getValidationMessage('too-small', $maxCpmValue);
        }
        //less than arbitrary maxcpm 
        if ($valueValid) {
            $valueValid = $maxValidator->validate($value, $maxCpmValue);
            $message = $valueValid ?  null : getValidationMessage('too-big', $maxCpmValue);
        }
        //max 2decimal places?
        if ($valueValid) {
            $valueValid = $decimalValidator->validate($value, 2);
            $message = $valueValid ?  null : $message = getValidationMessage('format', $maxCpmValue);                
        }
        //not smaller than eCPM or campaigns CPM ('revenue')
        if ($valueValid) {
            $aCampaign = $aCampaigns[$campaignId];
            if (OX_oxMarket_Dal_CampaignsOptIn::isECPMEnabledCampaign($aCampaign)) {
                if (is_numeric($aCampaign['ecpm']) && $value < $aCampaign['ecpm']) {
                    $valueValid = false;
                    $message = getValidationMessage('compare-ecpm', $maxCpmValue, $aCampaign['ecpm']);
                }
            }
            else {
                if (is_numeric($aCampaign['revenue']) && $value < $aCampaign['revenue']) {
                    $valueValid = false;
                    $message = getValidationMessage('compare-rate', $maxCpmValue, $aCampaign['revenue']);
                }
            }
        }
        if (!$valueValid) {
            $invalidCpms[$campaignId] = $message;
        }
        $valid = $valid && $valueValid;
    }
    
    if (!$valid) {
        OA_Admin_UI::queueMessage('Specified CPM values contain errors. In order to opt in campaigns to Market, please correct the errors below.', 'local', 'error', 0);
    }
    $template->assign('minCpmsInvalid', $invalidCpms);

    return $valid;
}


function getValidationMessage($cause, $maxCpmValue, $value = null)
{
    switch($cause) {
        case 'too-small' : {
            $message = 'Please provide CPM value greater than zero';
            break;
        }
        case 'too-big' : {
            $message = 'Please provide CPM value smaller than '.formatCpm($maxCpmValue); 
            break;
        }
        case 'compare-ecpm' : {
            $message = "Please provide minimum CPM greater or equal to ".formatCpm($value)." (the campaign's eCPM)."; 
            break;
        }
        case 'compare-rate' : {
            $message = "Please provide minimum CPM greater or equal to ".formatCpm($value)." (the campaign's specified CPM)."; 
            break;
        }
        
        
        case 'format' : 
        default : {
            $message = 'Please provide CPM values as decimal numbers with two digit precision'; 
        }
    }
    
    return $message;
}


function formatCpm($cpm)
{
    return number_format($cpm, 2, '.', '');
}

function performOptIn($minCpms, $oCampaignsOptInDal)
{
    global $toOptIn, $minCpm, $campaignType;
    
    //for tracking reasons: count all currently opted in before additional optin
    $beforeCount = $oCampaignsOptInDal->numberOfOptedCampaigns();
    $campaignsOptedIn = $oCampaignsOptInDal->performOptIn('selected', $minCpms, $toOptIn, $minCpm);
    
    //for tracking reasons: count all currently opted in after additional optin
    $afterCount = $oCampaignsOptInDal->numberOfOptedCampaigns();
    
    //we do not count here campaigns which floor price was only updated
    $actualOptedCount = $afterCount - $beforeCount; //this should not be lower than 0 :)

    OA_Admin_UI::queueMessage('You have successfully opted <b>' . $actualOptedCount . ' campaign' .
        ($campaignsOptedIn > 1 ? 's' : '') . '</b> into OpenX Market', 'local', 'confirm', 0);         
        
    // Redirect back to the opt-in page
    $params = array('campaignType' => $campaignType, 
        'minCpm' => $minCpm, 'optedOutCount' => $actualOptedCount);
    OX_Admin_Redirect::redirect('plugins/oxMarket/market-campaigns-settings.php?' . http_build_query($params));
}

function performOptOut($oCampaignsOptInDal)
{
    global $toOptIn, $minCpm, $campaignType;
    
    //for tracking reasons: count all currently opted in before additional optin
    $beforeCount = $oCampaignsOptInDal->numberOfOptedCampaigns();
    $campaignsOptedOut = $oCampaignsOptInDal->performOptOut($toOptIn);
    
    //for tracking reasons: count all currently opted in after additional optin
    $afterCount = $oCampaignsOptInDal->numberOfOptedCampaigns();
    
    OA_Admin_UI::queueMessage('You have successfully opted out <b>' . $campaignsOptedOut . ' campaign' .
        ($campaignsOptedOut > 1 ? 's' : '') . '</b> of OpenX Market', 'local', 'confirm', 0);

    //we do not count here campaigns which floor price was only updated
    $actualOptedOutCount = $beforeCount-$afterCount; //this should not be lower than 0 :)         
        
    // Redirect back to the opt-in page
    $params = array('campaignType' => $campaignType, 
        'minCpm' => $minCpm, 'optedCount' => $actualOptedOutCount);
    OX_Admin_Redirect::redirect('plugins/oxMarket/market-campaigns-settings.php?' . http_build_query($params));
}


/**
 * Same as array_fill_keys(array_keys($array), $valueToFillIn)
 * but compatible with PHP < 5.2
 *
 * @param array $array
 * @param mixed $valueToFillIn
 * @return array
 */
function arrayValuesToKeys($array, $valueToFillIn = true)
{
    $result = array();
    foreach ($array as $value) {
    	$result[$value] = $valueToFillIn;
    }
    return $result;
}


function setupContentStrings($oMarketComponent, $oTpl, $optedCount)
{
    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-quickstart');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }
    
    $topMessage = isset($aContentKeys['top-message'])
        ? $aContentKeys['top-message']
        : '';
        
    $optInSubmitLabel = isset($aContentKeys['radio-opt-in-submit-label'])
        ? $aContentKeys['radio-opt-in-submit-label']
        : '';        
        
    $optOutSubmitLabel = isset($aContentKeys['radio-opt-out-submit-label'])
        ? $aContentKeys['radio-opt-out-submit-label']
        : '';        
        
    $optedCount = 10;
    if (isset($optedCount) && $optedCount > 0) { //use opted count tracker
        $trackerFrame = isset($aContentKeys['tracker-optin-iframe'])
            ? str_replace('$COUNT', $optedCount, $aContentKeys['tracker-optin-iframe'])
            : '';
    }
    else {
        $trackerFrame = isset($aContentKeys['tracker-view-iframe'])
            ? $aContentKeys['tracker-view-iframe']
            : '';
    }    
    
    $oTpl->register_function('ox_campaign_type_tag', 'ox_campaign_type_tag_helper');
    $oTpl->assign('topMessage', $topMessage);
    $oTpl->assign('optInSubmitLabel', $optInSubmitLabel);
    $oTpl->assign('optOutSubmitLabel', $optOutSubmitLabel);
    $oTpl->assign('trackerFrame', $trackerFrame);
}


function ox_campaign_type_tag_helper($aParams, &$smarty)
{
    if (isset($aParams['type'])) {
        $type = $aParams['type'];
        $translation = new OX_Translation ();
        
        
        if ($type == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL || $type == OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
            $class = 'tag-contract';
            $text = $translation->translate('Contract');
        } 
        elseif ($type == OX_CAMPAIGN_TYPE_ECPM) {
            $class = 'tag-remnant';
            $text = $translation->translate('eCPM');
        } 
        else {
            $class = 'tag-remnant';
            $text = $translation->translate('Remnant');
        }
        $text = strtolower($text);
        
        return '<div class="'.$class.' tag"><div class="t-b"><div class="l-r"><div class="val">'.$text.'</div></div></div></div>';
    } 
    else {
        $smarty->trigger_error("t: missing 'type' parameter");
    }
}
        
        

