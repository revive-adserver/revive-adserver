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
$Id:$
*/

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
                
        switch($pageId) {
            case 'advertiser-campaigns': {
                $oUI = OA_Admin_UI::getInstance();
                $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 
                    'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($this->oMarketComponent->getPluginVersion())));
                break;
            }
            
            case 'campaign-edit' : 
            case 'campaign-edit_new': {
                $oEntityHelper = $this->oMarketComponent->getEntityHelper();
                $hasMarket = $oEntityHelper->isMarketAdvertiser($pageData['clientid']);
                if (!($hasMarket)) { //only redirect to proper screens if it is market
                    return;
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
            case 'campaign-zone' : {
                $result = $this->campaignZoneBeforeContent($pageData, $smarty);
                break;
            }
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
        }
        
        return $result;        
    }

    
    protected function campaignZoneBeforeContent($pageData, $smarty)
    {
        //TODO get campaign here from db check if it's system and default
        $isSystem = true;
        $isDefault = true;
        if (!($isSystem && $isDefault)) { //only default system campaign screen will be modified
            return null;
        }
        
        
        $oTpl = new OA_Plugin_Template('fragment-campaign-zone.html','oxMarket');
        $oTpl->assign('before', true);
        return $oTpl->toString();
    }
    
    
    protected function campaignZoneAfterContent($pageData, $smarty)
    {
        $oTpl = new OA_Plugin_Template('fragment-campaign-zone.html','oxMarket');
        $oTpl->assign('after', true);
        
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

        if (!isset($infoShown) || !$infoShown) {
            $oPreferenceDal->setMarketUserVariable('advertiser_index_market_info_shown_to_user', '1');
        }
        
        $oTpl->assign('content', $content);
        $oTpl->assign('showMarketInfo', !isset($infoShown) || !$infoShown);
        
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
        return $oTpl->toString();
    }
}
