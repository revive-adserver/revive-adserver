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

require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Dal/Advertiser.php';

/**
 * A listener of UI events. eg. renders additional content before campaign list.
 */
class OX_oxMarket_UI_EntityScreenManager
{
    /**
     * Bacl reference market component
     *
     * @var Plugins_admin_oxMarket_oxMarket
     */
    private $oMarketComponent;
    

    public function  __construct(Plugins_admin_oxMarket_oxMarket $oMarketComponent)
    {
        $this->oMarketComponent = $oMarketComponent;
    }

    
    public function beforePageHeader(OX_Admin_UI_Event_EventContext $oEventContext)
    {
        $pageId = $oEventContext->data['pageId'];
        $pageData = $oEventContext->data['pageData'];
        $oHeaderModel = $oEventContext->data['headerModel'];
        $oEntityHelper = $this->oMarketComponent->getEntityHelper();
        $oUI = OA_Admin_UI::getInstance();
                
        switch($pageId) {
            case 'advertiser-index': {
                $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 
                    'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($this->oMarketComponent->getPluginVersion()) . '&b=' . $this->oMarketComponent->aBranding['key']));
                break;
            }
            
            
            case 'advertiser-campaigns': {
                $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 
                    'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($this->oMarketComponent->getPluginVersion()) . '&b=' . $this->oMarketComponent->aBranding['key']));
                if (isset($oHeaderModel) && $oEntityHelper->isMarketAdvertiser($pageData['clientid'])) {
                    $oHeaderModel->setIconClass('iconCampaignsSystemLarge');
                }
                break;
            }
            

            case 'market-campaign-edit_new': {
                if (isset($oHeaderModel)) {
                    $oHeaderModel->setIconClass('iconCampaignSystemAddLarge');
                }
                break;
            }
            
            case 'market-campaign-edit':
            case 'market-campaign-acl': {    
                if (isset($oHeaderModel)) {
                    $oHeaderModel->setIconClass('iconCampaignSystemLarge');
                }
                break;
            }
            
            
            case 'campaign-zone': {
                if (isset($oHeaderModel) && $oEntityHelper->isMarketAdvertiser($pageData['clientid'])) {
                    $oHeaderModel->setIconClass('iconCampaignSystemLarge');
                }
                break;
            }
            
            
            case 'campaign-edit' : 
            case 'campaign-edit_new': {
                $hasMarket = $oEntityHelper->isMarketAdvertiser($pageData['clientid']);
                if (!($hasMarket)) { //only redirect to proper screens if it is market
                    break;
                }
                OX_Admin_Redirect::redirect('plugins/' . $this->oMarketComponent->group 
                    . '/market-campaign-edit.php?clientid='.$pageData['clientid']
                    .'&campaignid='.$pageData['campaignid']);
                
                break;
            }
        }        
    }
    
    
    public function beforeContent(OX_Admin_UI_Event_EventContext $oEventContext)    
    {
        $pageId = $oEventContext->data['pageId'];
        $pageData = $oEventContext->data['pageData'];
        $smarty = $oEventContext->data['oTpl'];
        
        $result = '';
        switch($pageId) {
            case 'advertiser-campaigns': {
                $result = $this->advertiserCampaignsBeforeContent($pageData, $smarty);
                break;
            }
        }
        
        return $result;
    }
    
    
    public function afterContent(OX_Admin_UI_Event_EventContext $oEventContext)
    {
        $pageId = $oEventContext->data['pageId'];
        $pageData = $oEventContext->data['pageData'];
        $smarty = $oEventContext->data['oTpl'];        
        
        $result = '';
        switch($pageId) {
            case 'campaign-zone' : {
                if ($this->oMarketComponent->getEntityHelper()->isMarketCampaign($pageData['campaignId'])) {
                    $result = $this->campaignZoneAfterContent($pageData, $smarty);
                }
                break;
            }
            case 'advertiser-index' : {
                $result = $this->advertiserIndexAfterContent($pageData, $smarty);
                break;
            }
            case 'advertiser-campaigns': {
                $result = $this->advertiserCampaignsAfterContent($pageData, $smarty);
                break;
            }
        }
        
        return $result;        
    }
    
    
    protected function campaignZoneAfterContent($pageData, $smarty)
    {
        $oTpl = new OA_Plugin_Template('fragment-campaign-zone.html','oxMarket');
        $oTpl->assign('after', true);
        $oTpl->assign('aBranding', $this->oMarketComponent->aBranding);
        
        return $oTpl->toString();
    }    
    
    
    protected function advertiserIndexAfterContent($pageData, $smarty)
    {
        $oTpl = new OA_Plugin_Template('fragment-advertiser-index.html','oxMarket');
        
        //retrieve alternative content if any
        $aContentKeys = $this->oMarketComponent->retrieveCustomContent('market-advertiser-index');
        if (!$aContentKeys) {
            $aContentKeys = array();
        }
        $content = $aContentKeys['content-bottom'];          
        
        $oPreferenceDal = $this->oMarketComponent->getPreferenceManager(); 
        $infoShown = $oPreferenceDal->getMarketUserVariable('advertiser_index_market_info_shown_to_user');
        $showInfo = !isset($infoShown) || !$infoShown;

        if ($showInfo) {
            $oPreferenceDal->setMarketUserVariable('advertiser_index_market_info_shown_to_user', '1');
        }
        
        $dalAdvertiser = new OX_oxMarket_Dal_Advertiser();
        $agency_id = OA_Permission::getEntityId();
        $oAdvertiser = $dalAdvertiser->getMarketAdvertiser($agency_id);
        $marketClientId = $oAdvertiser->clientid;
        
        $oTpl->assign('marketClientId', $marketClientId);
        $oTpl->assign('content', $content);
        $oTpl->assign('showMarketInfo', $showInfo);
        $oTpl->assign('aBranding', $this->oMarketComponent->aBranding);
        
        return $oTpl->toString();
    }    
    
   
    /*
     * A view listener function that inserts some market content on campaigns 
     * screen only if current advertiser is OpenX Market.
     */
    protected function advertiserCampaignsBeforeContent($pageData, $smarty)
    {
        $oEntityHelper = $this->oMarketComponent->getEntityHelper();
        $hasMarket = $oEntityHelper->isMarketAdvertiser($pageData['advertiserId']);
        if (!($hasMarket)) { //only default system campaign screen will be modified
            return null;
        }
        
        //retrieve alternative content if any
        $aContentKeys = $this->oMarketComponent->retrieveCustomContent('market-advertiser-campaigns');
        if (!$aContentKeys) {
            $aContentKeys = array();
        }
        $content = $aContentKeys['content-top'];      

        $oTpl = new OA_Plugin_Template('fragment-advertiser-campaigns.html','oxMarket');
        $oTpl->assign('content', $content);
        $oTpl->assign('before', true);
        $oTpl->assign('aBranding', $this->oMarketComponent->aBranding);
        
        return $oTpl->toString();
    }
    
    
    /*
     * A view listener function that inserts some market content on campaigns 
     * screen only if current advertiser is OpenX Market.
     */
    protected function advertiserCampaignsAfterContent($pageData, $smarty)
    {
        $oEntityHelper = $this->oMarketComponent->getEntityHelper();
        $hasMarket = $oEntityHelper->isMarketAdvertiser($pageData['advertiserId']);
        if (!($hasMarket)) { //only default system campaign screen will be modified
            return null;
        }
        
        $oTpl = new OA_Plugin_Template('fragment-advertiser-campaigns.html','oxMarket');
        $oTpl->assign('content', $content);
        $oTpl->assign('after', true);
        $oTpl->assign('aBranding', $this->oMarketComponent->aBranding);
        
        return $oTpl->toString();
    }
    
    
}
