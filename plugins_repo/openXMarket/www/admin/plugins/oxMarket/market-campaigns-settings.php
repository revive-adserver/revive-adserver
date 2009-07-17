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
if (!$oMarketComponent->isMarketSettingsAlreadyShown()) {
    $oMarketComponent->setMarketSettingsAlreadyShown();
}
$defaultMinCpm = $oMarketComponent->getConfigValue('defaultFloorPrice');
$maxCpm = $oMarketComponent->getMaxFloorPrice(); //used for validation purpose only
/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

//header
$oUI = OA_Admin_UI::getInstance();
$oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css'));
$oMenu = OA_Admin_Menu::singleton();

// Register some variables from the request
$request = phpAds_registerGlobalUnslashed('campaignType', 'optInType', 'toOptIn', 'minCpm', 'optedCount');
if (empty($campaignType)) {
    $campaignType = 'remnant';
}
if (empty($optInType)) {
    $optInType = 'selected';
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
$campaigns = $oCampaignsOptInDal->getCampaigns($defaultMinCpm, $campaignType, $minCpms);
if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_REQUEST['opt-in-submit']) && isDataValid($oTpl, $campaigns, $maxCpm))
{
    performOptIn($minCpms, $oCampaignsOptInDal);
    exit(0);
}



// The number of campaigns of $campaignType that have already been
// opted in to the Market. We need this number to tell the difference between the
// $campaigns list being empty because all campaigns have been opted-in and because
// there are no campaigns in the inventory at all. In the first case $campaignsOptedIn
// will be > 0 and in the latter $campaignsOptedIn will be 0.
$campaignsOptedIn = $oCampaignsOptInDal->numberOfOptedCampaigns($campaignType);

// The number of remnant campaigns that can be opted-in.
// This will display in the "Opt in all X of your existing remnant campaigns to OpenX Market"
// radio button label on the screen.
$remnantCampaignsToOptIn = $oCampaignsOptInDal->numberOfRemnantCampaignsToOptIn();
$remnantCampaignsOptedIn = $oCampaignsOptInDal->numberOfOptedCampaigns('remnant');

$toOptIn = empty($toOptIn) ? array() : $toOptIn;


setupContentStrings($oMarketComponent, $oTpl, $optedCount);
$oTpl->assign('campaigns', $campaigns);
$oTpl->assign('campaignsOptedIn', $campaignsOptedIn);
$oTpl->assign('campaignType', $campaignType);
$oTpl->assign('optInType', $optInType);
$oTpl->assign('remnantCampaignsCount', $remnantCampaignsToOptIn);
$oTpl->assign('remnantCampaignsOptedIn', $remnantCampaignsOptedIn);
$oTpl->assign('minCpm', $minCpm);
$oTpl->assign('maxValueLength', 3 + strlen($maxCpm)); //two decimal places, point, plus strlen of maxCPM
$oTpl->assign('minCpms', $minCpms);
$firstView = empty($toOptIn);
$oTpl->assign('firstView', $firstView);
$toOptInMap = arrayValuesToKeys($toOptIn);
foreach ($campaigns as $campaignId => $campaign) {
	if (!isset($toOptInMap[$campaignId])) {
	    $toOptInMap[$campaignId] = $firstView;
	}
}
$oTpl->assign('toOptIn', $toOptInMap);

// Display the page
$oCurrentSection = $oMenu->get("market-campaigns-settings");
phpAds_PageHeader("market-campaigns-settings", new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName(), "iconMarketLarge"), '../../', true, true, true, false);

$oTpl->display();

//footer
phpAds_PageFooter();

function isDataValid($template, $aCampaigns, $maxCpmValue)
{
    global $optInType, $toOptIn, $minCpm;
    $valid = true;
    $zero = false;
    $decimalValidator = new OA_Admin_UI_Rule_DecimalPlaces();
    $maxValidator = new OA_Admin_UI_Rule_Max();
    

//    if ($optInType == 'remnant') {
//        $valid = is_numeric($minCpm) && $decimalValidator->validate($minCpm, 2); 
//        if ($valid) {
//            $tooSmall = ($minCpm <= 0);
//            $tooBig = !$maxValidator->validate($minCpm, $maxCpmValue); 
//            $valid = $valid && !$tooSmall && !$tooBig;
//        }
//        if (!$valid) {
//            $template->assign('minCpmInvalid', true);
//            if ($tooSmall) {
//                OA_Admin_UI::queueMessage('Please provide CPM values greater than zero', 'local', 'error', 0);
//            }
//            else if ($tooBig) {
//                OA_Admin_UI::queueMessage('Please provide CPM values smaller than '.formatCpm($maxCpmValue), 'local', 'error', 0);
//            } 
//            
//            else {
//                OA_Admin_UI::queueMessage('Please provide CPM values as decimal numbers with two digit precision', 'local', 'error', 0);
//            }
//        }
//    } 
//    else {
    if ($optInType == 'selected') {
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
    }

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
            $message = "Please provide minimum CPM greater than ".formatCpm($value)." (the campaign's eCPM)."; 
            break;
        }
        case 'compare-rate' : {
            $message = "Please provide minimum CPM greater than ".formatCpm($value)." (the campaign's specified CPM)."; 
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
    global $optInType, $toOptIn, $minCpm, $campaignType;
    
    //for tracking reasons: count all currently opted in before additional optin
    $beforeCount = $oCampaignsOptInDal->numberOfOptedCampaigns();
    $campaignsOptedIn = $oCampaignsOptInDal->performOptIn($optInType, $minCpms, $toOptIn, $minCpm);
    
    //for tracking reasons: count all currently opted in after additional optin
    $afterCount = $oCampaignsOptInDal->numberOfOptedCampaigns();
    
    OA_Admin_UI::queueMessage('You have successfully opted <b>' . $campaignsOptedIn . ' campaign' .
        ($campaignsOptedIn > 1 ? 's' : '') . '</b> into OpenX Market', 'local', 'confirm', 0);

    //we do not count here campaigns which floor price was only updated
    $actualOptedCount = $afterCount - $beforeCount; //this should not be lower than 0 :)         
    // Redirect back to the opt-in page
    $params = array('optInType' => $optInType, 'campaignType' => $campaignType, 
        'minCpm' => $minCpm, 'optedCount' => $actualOptedCount);
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
        
    $optInAllRadioLabel = isset($aContentKeys['radio-opt-in-all-label'])
        ? $aContentKeys['radio-opt-in-all-label']
        : '';

    $optInAllFieldCpmLabel = isset($aContentKeys['field-opt-in-some-label'])
        ? $aContentKeys['field-opt-in-some-label']
        : '';
        
    $optInAllFieldCpmLabelSuffix = isset($aContentKeys['field-opt-in-some-label-suffix'])
        ? $aContentKeys['field-opt-in-some-label-suffix']
        : '';
        
    $optInSomeRadioLabel = isset($aContentKeys['radio-opt-in-some-label'])
        ? $aContentKeys['radio-opt-in-some-label']
        : '';
        
    $optInSubmitLabel = isset($aContentKeys['radio-opt-in-submit-label'])
        ? $aContentKeys['radio-opt-in-submit-label']
        : '';        
        
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
    
    $oTpl->assign('topMessage', $topMessage);
    $oTpl->assign('optInAllRadioLabel', $optInAllRadioLabel);
    $oTpl->assign('optInAllFieldCpmLabel', $optInAllFieldCpmLabel);
    $oTpl->assign('optInAllFieldCpmLabelSuffix', $optInAllFieldCpmLabelSuffix);
    $oTpl->assign('optInSomeRadioLabel', $optInSomeRadioLabel);
    $oTpl->assign('optInSubmitLabel', $optInSubmitLabel);
    $oTpl->assign('trackerFrame', $trackerFrame);
}

