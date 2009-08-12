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

require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/rule/DecimalPlaces.php';
require_once MAX_PATH .'/lib/pear/HTML/QuickForm/Rule/Regex.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/rule/Max.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Dal/CampaignsOptIn.php';

/**
 * 
 */
class OX_oxMarket_UI_CampaignsSettings
{
    /**
     * @var Plugins_admin_oxMarket_oxMarket
     */
    private $marketComponent;

    /**
     * @var OX_oxMarket_Dal_CampaignsOptIn
     */
    private $campaignsOptInDal;
    
    private $campaigns;

    private $campaignType;
    private $search;
    private $minCpms;
    private $defaultMinCpm;
    private $itemsPerPage = 5;
    private $currentPage;
    
    private $toOptIn;
    private $optedCount;
    private $maxCpm;
    
    
    public function __construct()
    {
        $this->marketComponent = OX_Component::factory('admin', 'oxMarket');
        $this->campaignsOptInDal = new OX_oxMarket_Dal_CampaignsOptIn();
        
        // Get configuration defaults
        $this->defaultMinCpm = $this->marketComponent->getConfigValue('defaultFloorPrice');
        $this->maxCpm = $this->marketComponent->getMaxFloorPrice(); //used for validation purpose only
    }


    /**
     * A dispatcher method for handling all requests for the market settings screen.
     * 
     * @return a template to display or null if a HTTP redirect has been performed 
     *      after a successful form submission. 
     */
    public function handle()
    {
        // Initial checks
        $this->marketComponent->checkActive();
        if (!$this->marketComponent->isMarketSettingsAlreadyShown()) {
            $this->marketComponent->setMarketSettingsAlreadyShown();
        }
        
        //
        $this->parseRequestParameters();

        // Prepare a list of campaigns involved
        $this->campaigns = $this->campaignsOptInDal->getCampaigns($this->defaultMinCpm, 
            $this->campaignType, $this->minCpms, $this->search);
            
        // For POSTs, perform opt in/out and redirect
        if ('POST' == $_SERVER['REQUEST_METHOD']) { 
            if (!empty($_REQUEST['action']) && 'refresh' == $_REQUEST['action']) {
                return $this->displayAjaxList();
            }
            elseif (isset($_REQUEST['optInSubmit'])) {
                $invalidCpmMessages = $this->validateCpms($this->campaigns);
                if (empty($invalidCpmMessages)) {
                    $this->performOptIn();
                    return null;
                }
            } 
            elseif (isset($_REQUEST['optOutSubmit'])) {
                $this->performOptOut();
                return null;
            } 
        }
        
        return $this->displayFullList($invalidCpmMessages);
    }

    
    private function displayFullList($invalidCpmMessages)
    {
        $oTpl = new OA_Plugin_Template('market-campaigns-settings.html','openXMarket');
        $this->assignCampaignsListModel($oTpl);
        $this->assignContentStrings($oTpl);
        
        if ($_COOKIE['market-settings-info-box-hidden']) {
            $oTpl->assign('infoBoxHidden', true);
        }
            
        if (!empty($invalidCpmMessages)) {
            OA_Admin_UI::queueMessage('Specified CPM values contain errors. In order to ' . 
                'opt in campaigns to Market, please correct the errors below.', 'local', 'error', 0);
            $oTpl->assign('minCpmsInvalid', $invalidCpmMessages);
        }
        
        return $oTpl;
    }

    
    private function displayAjaxList()
    {
        $oTpl = new OA_Plugin_Template('market-campaigns-settings-list.html','openXMarket');
        $this->assignCampaignsListModel($oTpl);
        return $oTpl;
    }
    
    
	public function assignCampaignsListModel($template)
    {
        $template->register_function('ox_campaign_type_tag', 
            array($this, 'ox_campaign_type_tag_helper'));

        $template->assign('campaignType', $this->campaignType);
        $template->assign('search', $this->search);
        $template->assign('maxValueLength', 3 + strlen($this->maxCpm)); //two decimal places, point, plus strlen of maxCPM
        $template->assign('minCpms', $this->minCpms);
        
        $bottomPager = OX_buildPager($this->campaigns, $this->itemsPerPage, true, '', 4, $this->currentPage, 
            'market-campaigns-settings-list.php');
        $topPager = OX_buildPager($this->campaigns, $this->itemsPerPage, false, '', 4, $this->currentPage, 
            'market-campaigns-settings-list.php');
        list($itemsFrom, $itemsTo) = $bottomPager->getOffsetByPageId();
        $template->assign('pager', $bottomPager);
        $template->assign('topPager', $topPager);
        $template->assign('page', $bottomPager->getCurrentPageID());
        
        $this->campaigns =  array_slice($this->campaigns, $itemsFrom - 1, 
            $this->itemsPerPage, true);
        $template->assign('campaigns', $this->campaigns);
        
        $toOptInMap = self::arrayValuesToKeys($this->toOptIn);
        foreach ($this->campaigns as $campaignId => $campaign) {
            if (!isset($toOptInMap[$campaignId])) {
                $toOptInMap[$campaignId] = false;
            }
        }
        $template->assign('toOptIn', $toOptInMap);
    }

    
    private function performOptIn()
    {
        //for tracking reasons: count all currently opted in before additional optin
        $beforeCount = $this->campaignsOptInDal->numberOfOptedCampaigns();
        $campaignsOptedIn = $this->campaignsOptInDal->performOptIn(
            'selected', $this->minCpms, $this->toOptIn, $this->defaultMinCpm);
        
        //for tracking reasons: count all currently opted in after additional optin
        $afterCount = $this->campaignsOptInDal->numberOfOptedCampaigns();
        
        //we do not count here campaigns which floor price was only updated
        $actualOptedCount = $afterCount - $beforeCount; //this should not be lower than 0 :)
    
        OA_Admin_UI::queueMessage('You have successfully opted <b>' . $actualOptedCount . ' campaign' .
            ($campaignsOptedIn > 1 ? 's' : '') . '</b> into OpenX Market', 'local', 'confirm', 0);         

        $this->redirect($actualOptedCount);
    }
    
    private function performOptOut()
    {
        //for tracking reasons: count all currently opted in before additional optin
        $beforeCount = $this->campaignsOptInDal->numberOfOptedCampaigns();
        $campaignsOptedOut = $this->campaignsOptInDal->performOptOut($this->toOptIn);
        
        //for tracking reasons: count all currently opted in after additional optin
        $afterCount = $this->campaignsOptInDal->numberOfOptedCampaigns();
        
        OA_Admin_UI::queueMessage('You have successfully opted out <b>' . $campaignsOptedOut . ' campaign' .
            ($campaignsOptedOut > 1 ? 's' : '') . '</b> of OpenX Market', 'local', 'confirm', 0);
    
        //we do not count here campaigns which floor price was only updated
        $actualOptedOutCount = $beforeCount-$afterCount; //this should not be lower than 0 :)

        $this->redirect($actualOptedOutCount);
    }
    
    
	private function redirect($actualOptedOutCount)
    {
        $params = array(
            'campaignType' => $this->campaignType, 
            'optedCount' => $actualOptedOutCount, 
            'p' => $this->currentPage
        );
        OX_Admin_Redirect::redirect('plugins/oxMarket/market-campaigns-settings.php?' . http_build_query($params));
    }
    

    private function parseRequestParameters()
    {
        $request = phpAds_registerGlobalUnslashed('campaignType', 'toOptIn', 'optedCount', 'search', 'p');
        $this->campaignType = !empty($request['campaignType']) ? $request['campaignType'] : 'remnant';
        $this->toOptIn = isset($request['toOptIn']) ? $request['toOptIn'] : array();
        $this->optedCount = $request['optedCount'];
        $this->search = !empty($request['search']) ? $request['search'] : null;
        $this->currentPage = !empty($request['p']) ? $request['p'] : null;

        $this->minCpms = array();
        foreach ($_REQUEST as $param => $value) {
            if (preg_match("/^cpm\d+$/", $param)) {
                $this->minCpms[substr($param, 3)] = $value;
            }
        }
    }
    
    
    private function validateCpms($campaigns)
    {
        $valid = true;
        $zero = false;
        $decimalValidator = new OA_Admin_UI_Rule_DecimalPlaces();
        $maxValidator = new OA_Admin_UI_Rule_Max();
        
        $invalidCpms = array();
        foreach ($this->toOptIn as $campaignId) {
            $value = $_REQUEST['cpm' . $campaignId];
            //is number
            $valueValid = is_numeric($value);
            
            $message = $valueValid ?  null : $message = $this->getValidationMessage('format');
            
            //is greater than zero
            if ($valueValid) {
                $valueValid = ($value > 0);
                $message = $valueValid ?  null : $message = $this->getValidationMessage('too-small');
            }
            //less than arbitrary maxcpm 
            if ($valueValid) {
                $valueValid = $maxValidator->validate($value, $this->maxCpm);
                $message = $valueValid ?  null : $this->getValidationMessage('too-big');
            }
            //max 2decimal places?
            if ($valueValid) {
                $valueValid = $decimalValidator->validate($value, 2);
                $message = $valueValid ?  null : $message = $this->getValidationMessage('format');                
            }
            //not smaller than eCPM or campaigns CPM ('revenue')
            if ($valueValid) {
                $aCampaign = $campaigns[$campaignId];
                if (OX_oxMarket_Dal_CampaignsOptIn::isECPMEnabledCampaign($aCampaign)) {
                    if (is_numeric($aCampaign['ecpm']) && $value < $aCampaign['ecpm']) {
                        $valueValid = false;
                        $message = $this->getValidationMessage('compare-ecpm', $aCampaign['ecpm']);
                    }
                }
                else {
                    if (is_numeric($aCampaign['revenue']) && $value < $aCampaign['revenue']
                        && $aCampaign['revenue_type'] == MAX_FINANCE_CPM) {
                        $valueValid = false;
                        $message = $this->getValidationMessage('compare-rate', $aCampaign['revenue']);
                    }
                }
            }
            if (!$valueValid) {
                $invalidCpms[$campaignId] = $message;
            }
            $valid = $valid && $valueValid;
        }
        return $invalidCpms;
    }


    private function getValidationMessage($cause, $value = null)
    {
        switch($cause) {
            case 'too-small' : {
                $message = 'Please provide CPM value greater than zero';
                break;
            }
            case 'too-big' : {
                $message = 'Please provide CPM value smaller than ' . self::formatCpm($this->maxCpm); 
                break;
            }
            case 'compare-ecpm' : {
                $message = "Please provide minimum CPM greater or equal to " . self::formatCpm($value) . " (the campaign's eCPM)."; 
                break;
            }
            case 'compare-rate' : {
                $message = "Please provide minimum CPM greater or equal to " . self::formatCpm($value) . " (the campaign's specified CPM)."; 
                break;
            }
            
            case 'format' : 
            default : {
                $message = 'Please provide CPM values as decimal numbers with two digit precision'; 
            }
        }
        
        return $message;
    }
    
    
    public static function formatCpm($cpm)
    {
        return number_format($cpm, 2, '.', '');
    }
    

    function assignContentStrings($oTpl)
    {
        $aContentKeys = $this->marketComponent->retrieveCustomContent('market-quickstart');
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
        
        $oTpl->assign('topMessage', $topMessage);
        $oTpl->assign('optInSubmitLabel', $optInSubmitLabel);
        $oTpl->assign('optOutSubmitLabel', $optOutSubmitLabel);
        $oTpl->assign('trackerFrame', $trackerFrame);
    }
    
    
    public function ox_campaign_type_tag_helper($aParams, &$smarty)
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

    /**
     * Same as array_fill_keys(array_keys($array), $valueToFillIn)
     * but compatible with PHP < 5.2
     *
     * @param array $array
     * @param mixed $valueToFillIn
     * @return array
     */
    private static function arrayValuesToKeys($array, $valueToFillIn = true)
    {
        $result = array();
        foreach ($array as $value) {
            $result[$value] = $valueToFillIn;
        }
        return $result;
    }
}
