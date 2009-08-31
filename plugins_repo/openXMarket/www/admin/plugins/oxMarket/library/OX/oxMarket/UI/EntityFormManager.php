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

require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';

/**
 * 
 */
class OX_oxMarket_UI_EntityFormManager
{
    /**
     * @var Plugins_admin_oxMarket_oxMarket
     */
    private $marketComponent;

    public function __construct(Plugins_admin_oxMarket_oxMarket $marketComponent = null)
    {
        $this->marketComponent = $marketComponent;
    }
    
    
    public function buildCampaignFormPart(&$form, $campaign, $newCampaign)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $defaultFloorPrice = !empty($aConf['oxMarket']['defaultFloorPrice'])
            ? (float) $aConf['oxMarket']['defaultFloorPrice']
            : NULL;
        $defaultFloorPrice = $this->formatCpm($defaultFloorPrice);
        $maxFloorPriceValue = $this->marketComponent->getMaxFloorPrice();
        
        $aFields = array(
            'mkt_is_enabled' => 'f',
            'floor_price' => $defaultFloorPrice
        );
        $dboExt_market_campaign_pref = OA_Dal::factoryDO('ext_market_campaign_pref');
        if (!$newCampaign && $dboExt_market_campaign_pref->get($campaign['campaignid'])) {
            $aFields = array(
                'mkt_is_enabled' => $dboExt_market_campaign_pref->is_enabled ? 't' : 'f',
                'floor_price' => !empty($dboExt_market_campaign_pref->floor_price) ? (float) $dboExt_market_campaign_pref->floor_price : ''
            );
        }
        $aFields['floor_price'] = $this->formatCpm($aFields['floor_price']);

        $form->addElement ( 'header', 'h_marketplace', "Maximize Ad Revenue");

        $aMktEnableGroup[] = $form->createElement('advcheckbox', 'mkt_is_enabled', null, $this->marketComponent->translate("Allow OpenX Market to show ads for this campaign if it beats the CPM below (RECOMMENDED)"), array('id' => 'enable_mktplace'), array("f", "t"));
        $aMktEnableGroup[] = $form->createElement('plugin-custom', 'market-callout', 'oxMarket');
        $form->addGroup($aMktEnableGroup, 'mkt_enabled_group', null);

        $aFloorPrice[] = $form->createElement('html', 'floor_price_label', $this->marketComponent->translate("Serve an ad from OpenX Market if it pays higher than this CPM &nbsp;&nbsp;$"));
        $aFloorPrice[] = $form->createElement('text', 'floor_price', null, array('class' => 'x-small', 'id' => 'floor_price', 'maxlength' => 3 + strlen($maxFloorPriceValue)));
        $aFloorPrice[] = $form->createElement('static', 'floor_price_usd', '<label for="floor_price">'.$this->marketComponent->translate("USD").'</label>');
        $aFloorPrice[] = $form->createElement('plugin-custom', 'market-cpm-callout', 'oxMarket');
        $form->addGroup($aFloorPrice, 'floor_price_group', '');
        $form->addElement('plugin-script', 'campaign-script', 'oxMarket', 
            array('defaultFloorPrice' => $defaultFloorPrice));
        $form->addElement('plugin-script', 'market-floor-price-dialog', 'oxMarket', 
            array());

        
        //in order to get conditional validation, check if it is POST 
        //and if market was enabled and add group rules
        if (isset($_POST['mkt_is_enabled']) && $_POST['mkt_is_enabled'] == 't') { 
            //Form validation rules
            $form->addGroupRule('floor_price_group', array(
                'floor_price' => array(
                    array($this->marketComponent->translate('%s is required', array($this->marketComponent->translate('Campaign floor price'))), 'required'),
                    array($this->marketComponent->translate("%s must be a minimum of at least 0.01", array($this->marketComponent->translate('Campaign floor price'))), 'min', 0.01),
                    array($this->marketComponent->translate("Must be a decimal with maximum %s decimal places", array('2')), 'decimalplaces', 2),
                    array($this->marketComponent->translate("%s must be less than %s", array('Campaign floor price', $maxFloorPriceValue)), 'max', $maxFloorPriceValue)
                )
            ));
        }        

        $form->setDefaults($aFields);
    }
    
    
    public function buildCampaignFormPartForInactive(&$form, $campaign, $newCampaign)
    {
        $oUI = OA_Admin_UI::getInstance();
        $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css'));

        $form->addElement ( 'header', 'h_marketplace', "Maximize Ad Revenue");

        if (OA_Permission::isUserLinkedToAdmin()) {
            $url = MAX::constructURL(MAX_URL_ADMIN, 'plugins/' . $this->marketComponent->group . '/market-info.php');
            $message =
                "<div class='market-invite'>
                    Earn more revenue by activating OpenX Market for your instance  of OpenX Ad Server.
                    <a href='".$url."'><b>Get started now &raquo;</b></a>
                </div>";
        }
        else {
            $aMailContents = $this->buildAdminEmail();
            $url =  "mailto:".$aMailContents['to']."?subject=".$aMailContents['subject']."&body=".$aMailContents['body'];
            $message = "You can earn more revenue by having your OpenX Administrator activate OpenX Market for your instance of OpenX Ad Server.
            <br><a href='".$url."'><b>Contact your administrator &raquo;</b></a>";
        }


        $form->addElement('html', 'get_started', $message);
        
    }
    
    
    public function processCampaignForm(&$aFields)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oExt_market_campaign_pref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $oExt_market_campaign_pref->updateCampaignStatus($aFields['campaignid'], 
            $aFields['mkt_is_enabled'] == 't', $aFields['floor_price']);
            
        // invalidate campaign-market delivery cache
        if (!function_exists('OX_cacheInvalidateGetCampaignMarketInfo')) {
            require_once MAX_PATH . $aConf['pluginPaths']['plugins'] . 'deliveryAdRender/oxMarketDelivery/oxMarketDelivery.delivery.php';
        }
        OX_cacheInvalidateGetCampaignMarketInfo($aFields['campaignid']);
    }    
    
    
    public function processWebsiteForm(&$aFields)
    {
        $affiliateId = $aFields['affiliateid'];
        $websiteUrl = $aFields['website'];
        if ($this->marketComponent->getAccountId()) {
            //get current market website id if any, do not autogenerate
            $websiteManager = $this->marketComponent->getWebsiteManager();
            $websiteId = $websiteManager->getWebsiteId($affiliateId, false);

            //genereate new id if it does not exist
            if (empty($websiteId)) {
                try {
                    $websiteId = $websiteManager->generateWebsiteId($websiteUrl);
                    $websiteManager->setWebsiteId($affiliateId, $websiteId);
                    $restricted = $websiteManager->insertDefaultRestrictions($affiliateId);
                    $message =  'Website has been registered in OpenX Market';
                    if ($restricted) {
                        $message.= ' and its default restrictions have been set.';
                    }
                    else {
                        $message.= ', but there was an error when setting default restrictions.';
                    }

                    OA_Admin_UI::queueMessage($message, 'local', $restricted ?'confirm' : 'error', $restricted ? 5000 : 0);
                } catch (Exception $e) {
                    OA::debug('openXMarket: Error during register website in OpenX Market : '.$e->getMessage());
                    $message = 'Unable to register website in OpenX Market.';
                    $aError = split(':',$e->getMessage());
                    if ($aError[0]==Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::XML_ERR_ACCOUNT_BLOCKED) {
                        $message .= " Market account is blocked.";
                    }
                    OA_Admin_UI::queueMessage($message, 'local', 'error', 0);
                }
            }
            else {
                $oWebsite = & OA_Dal::factoryDO('affiliates');
                $oWebsite->get($affiliateId);
                $currentWebsiteUrl = $oWebsite->website;
                if ($currentWebsiteUrl != $websiteUrl) { //url changed
                    try {
                        $result = $websiteManager->updateWebsiteUrl($affiliateId, $websiteUrl, false);
                        if ($result!== true) {
                            throw new Exception($result);
                        }
                    }
                    catch (Exception $e) {
                        OA::debug('openXMarket: Error during updating website url of #'.$affiliateId.' : '.$e->getMessage());
                        $message = 'There was an error during updating website url in OpenX Market.';
                        $aError = split(':',$e->getMessage());
                        if ($aError[0]==Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::XML_ERR_ACCOUNT_BLOCKED) {
                            $message .= " Market account is blocked.";
                        }
                        OA_Admin_UI::queueMessage($message, 'local', 'error', 0);
                    }
                }
            }
        }
    }
    
    
    function buildZoneFormPart(&$form, $zone, $newZone)
    {
        $aMktEnableGroup[] = $form->createElement('advcheckbox', 'mkt_is_enabled', 
            $this->marketComponent->translate("If no ads are available for this zone... "),     
            $this->marketComponent->translate("Serve ads from OpenX Market (RECOMMENDED)"), array('id' => 'enable_mktplace'), array("f", "t"));
        $aMktEnableGroup[] = $form->createElement('plugin-custom', 'market-callout-zone', 'oxMarket');
        
        $form->addGroup($aMktEnableGroup, 'mkt_enabled_group', null);

        $form->addElement('plugin-script', 'zone-script', 'oxMarket', array());
        
        $aFields = array('mkt_is_enabled' => 'f');
        if (!$newZone && $this->marketComponent->getZoneOptInManager()->isOptedIn($zone['zoneid'])) {
            $aFields['mkt_is_enabled'] = 't';
        }
        
        $form->setDefaults($aFields);
    }
    
    
    /**
     * Submission handler for zone form. Invoked after zone is saved/updated
     * by ad server. Updates zone opt-in status. 
     *
     * @param array $aFields zone form submited values
     */
    public function processZoneForm(&$aFields)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        
        $oZoneMgr = $this->marketComponent->getZoneOptInManager();
        
        $oZoneMgr->updateZoneOptInStatus($aFields['zoneid'], 
            $aFields['mkt_is_enabled'] == 't');
    }    
    

    function buildZoneAdvancedFormPart(&$form, $zone)
    {
        $marketEnabled = $this->marketComponent->getZoneOptInManager()->isOptedIn($zone['zoneid']);
        
        if (!$marketEnabled) {
            return;
        }
        //cleanup
        $form->removeElement('g_chain', true); //remove chain group
        //add own elements
        $chainGroup[] = $form->createElement('plugin-custom', 'zone-chaining-disabled-info', 'oxMarket', null, array('websiteId' => $zone['affiliateid'], 'zoneId' => $zone['zoneid']));
        $form->addGroup($chainGroup, 'g_market_chain', null, array("<BR>", '', ''));
    }    
    
    
    /**
     * Formats given float, limiting number of decimal places to 2.
     *
     * @param unknown_type $cpm
     * @return unknown
     */
    protected function formatCpm($cpm)
    {
        return number_format($cpm, 2, '.', '');
    }

    
    protected function buildAdminEmail()
    {
        $aMail = array();
        $url = MAX::constructURL(MAX_URL_ADMIN, 'plugins/' . $this->group . '/market-info.php');

        $oUser = OA_Permission::getCurrentUser();
        $userFullName = $oUser->aUser['contact_name'].' ('.OA_Permission::getUserName().')';

        $aMail['to'] = join(',', $this->getAdminEmails());
        $aMail['subject'] = "Please activate OpenX Market for our instance of OpenX Ad Server";
        $aMail['body'] = "Help earn more revenue by activating OpenX Market for our ad server. Click this link to get started:%0D%0D<$url>%0D%0DThanks,%0D$userFullName";

        return $aMail;
    }


    protected function getAdminEmails()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');

        $doAccount_user_assoc->account_id = DataObjects_Accounts::getAdminAccountId();
        $doUsers->joinAdd($doAccount_user_assoc);
        $doUsers->active = 1;
        $doUsers->selectAdd();
        $doUsers->selectAdd('email_address');
        $doUsers->find();

        $aEmails = array();
        while ($doUsers->fetch()) {
            $aEmails[] = $doUsers->email_address;
        };

        return $aEmails;
    }    

}
