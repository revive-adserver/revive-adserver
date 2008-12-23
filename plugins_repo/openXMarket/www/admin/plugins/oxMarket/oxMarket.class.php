<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once LIB_PATH.'/Plugin/Component.php';
require_once LIB_PATH . '/Admin/Redirect.php';

require_once MAX_PATH. '/lib/JSON/JSON.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

require_once dirname(__FILE__) . '/pcApiClient/oxPublisherConsoleMarketPluginClient.php';

define('OWNER_TYPE_AFFILIATE',  0);
define('OWNER_TYPE_CAMPAIGN',   1);
define('SETTING_TYPE_CREATIVE_TYPE',    0);
define('SETTING_TYPE_CREATIVE_ATTRIB',  1);
define('SETTING_TYPE_CREATIVE_CATEGORY', 2);

/**
 *
 * @package    openXMarket
 * @subpackage oxMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 * @author     Bernard Lange <bernard.lange@openx.org>
 */
class Plugins_admin_oxMarket_oxMarket extends OX_Component
{
    public $aDefaultRestrictions; 
    
    /**
     * @var Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
     */
    public $oMarketPublisherClient; 
    
    function __construct() 
    {
        $this->oMarketPublisherClient = 
            new Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient();
        $aDefRestr = $this->oMarketPublisherClient->getDefaultRestrictions();
        $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB] = $aDefRestr['attribute']; 
        $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY] = $aDefRestr['category'];
        $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE] = $aDefRestr['type'];
    }

    
    function afterPricingFormSection(&$form, $campaign, $newCampaign)
    {
        if (!$this->isActive()) {
            return;
        }
        
        $aConf = $GLOBALS['_MAX']['CONF'];

        $defaultFloorPrice = !empty($aConf['oxMarket']['defaultFloorPrice'])
            ? (float) $aConf['oxMarket']['defaultFloorPrice']
            : NULL;

        $aFields = array(
            'mkt_is_enabled' => 'f',
            'floor_price' => $defaultFloorPrice
        );
        $dboExt_market_campaign_pref = OA_Dal::factoryDO('ext_market_campaign_pref');
        if ($dboExt_market_campaign_pref->get($campaign['campaignid'])) {
            $aFields = array(
                'mkt_is_enabled' => $dboExt_market_campaign_pref->is_enabled ? 't' : 'f',
                'floor_price' => !empty($dboExt_market_campaign_pref->floor_price) ? (float) $dboExt_market_campaign_pref->floor_price : ''
            );
        }

        $marketInfoUrl = MAX::constructURL(MAX_URL_ADMIN, '') . 'plugins/' . $this->group . '/market-info.php';
        
        if (OA_Permission::isUserLinkedToAdmin()) {
            $infoLink = $this->translate("(<a href='%s'>What is this?</a>)", array($marketInfoUrl));
        }
        $form->addElement ( 'header', 'h_marketplace', "OpenX Market " . $infoLink);

        //TODO externalize intro strings
        $form->addElement('static', 'enableIntro', null, $this->translate("Earn more money by participating in the OpenX Market"));
        $form->addElement('advcheckbox', 'mkt_is_enabled', null, $this->translate("Yes, serve a campaign from the OpenX Market if it beats my floor price."), array('id' => 'enable_mktplace'), array("f", "t"));
        $form->addElement('static', 'priceIntro', null, $this->translate("Set the floor price.  If an advertiser in the Market cannot beat it, your original ad will be shown."));

        $aFloorPrice[] = $form->createElement('text', 'floor_price', null, array('class' => 'x-small', 'id' => 'floor_price'));
        $aFloorPrice[] = $form->createElement('static', 'floor_price_usd', '<span class="hint">', $this->translate("Note: Floor price is in USD"));
        $form->addGroup($aFloorPrice, 'floor_price_group', $this->translate("Set campaign floor price"));
        $form->addElement('plugin-script', 'campaign-script', 'oxMarket', array('defaultFloorPrice' => $defaultFloorPrice));
        

        //Form validation rules
        $form->addGroupRule('floor_price_group', array(
            'floor_price' => array(
                array($this->translate("%s must be a minimum of at least 0.01", array($this->translate('Campaign floor price'))), 'min', 0.01),
                array($this->translate("Must be a decimal with maximum %s decimal places", array('2')), 'decimalplaces', 2)
            )
        ));

        $form->addFormRule(array($this, 'checkIfFloorPriceRequired'));

        $form->setDefaults($aFields);
    }

    function processCampaignForm(&$aFields)
    {
        if (!$this->isActive()) {
            return;
        }
        
        
        $oExt_market_campaign_pref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $oExt_market_campaign_pref->campaignid = $aFields['campaignid'];
        $recordExist = false;
        if ($oExt_market_campaign_pref->find()) {
            $oExt_market_campaign_pref->fetch();
            $recordExist = true;
        }
        $oExt_market_campaign_pref->is_enabled = $aFields['mkt_is_enabled'] == 't' ? 1 : 0;
        $oExt_market_campaign_pref->floor_price = $aFields['floor_price'];
        if ($recordExist) {
            $oExt_market_campaign_pref->update();
        } else {
            $oExt_market_campaign_pref->insert();
        }
        // invalidate campaign-market delivery cache
        //MAX_cacheInvalidateGetCampaignMarketInfo($aFields['campaignid']);
    }
    

    function insertDefaultRestrictions($affiliateId)
    {
        return $this->updateWebsiteRestrictions($affiliateId, 
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE], 
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB], 
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY]) 
            && $this->storeWebsiteRestrictions($affiliateId, 
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE],
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB], 
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY]);
    }
    

    function processAffiliateForm(&$aFields)
    {
        if (!$this->isActive()) {
            return;
        }
        
        $affiliateId = $aFields['affiliateid'];
        $websiteUrl = $aFields['website'];
        if ($this->getAccountId()) {
            //get current market website id if any, do not autogenerate
            $websiteId = $this->getWebsiteId($affiliateId, false);
            
            //genereate new id if it does not exist
            if (empty($websiteId)) {
                if ($websiteId = $this->generateWebsiteId($websiteUrl)) {
                    $this->setWebsiteId($affiliateId, $websiteId);
                    $restricted = $this->insertDefaultRestrictions($affiliateId);
                    $message =  'Website has been registered in OpenX Market';
                    if ($restricted) {
                        $message.= ' and its default restrictions have been set.';
                    }
                    else {
                        $message.= ', but there was an error when setting default restrictions.';
                    }
                    
                    OA_Admin_UI::queueMessage($message, 'local', $restricted ?'confirm' : 'error', $restricted ? 5000 : 0);
                } 
                else {
                    OA_Admin_UI::queueMessage('Unable to register website in OpenX Market.', 'local', 'error', 0);
                }
            }
        }
    }
    
    
    function getAgencyDetails($agencyId = null)
    {
        if (is_null($agencyId)) {
           $agencyId = OA_Permission::getAgencyId();
        }
        $doAgency = & OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId);
        $aResult = $doAgency->toArray();

        return $aResult;
    }


    /**
     * Retrieve the account id for market from associate  data
     */
    function getAccountId()
    {
        return $this->oMarketPublisherClient->getPcAccountId();
    }
    
    function getWebsiteIdAndUrl($affiliateId, $autoGenerate = true, &$websiteId, 
        &$websiteUrl)
    {
        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId);
        
        $oWebsite = & OA_Dal::factoryDO('affiliates');
        $oWebsite->get($affiliateId);

        if (empty($oWebsitePref->website_id) && $autoGenerate) {
            $websiteId = $this->generateWebsiteId($oWebsite->website);
            if (!empty($websiteId)) {
                $this->setWebsiteId($affiliateId, $websiteId);
            }
        } else {
            $websiteId = $oWebsitePref->website_id;
        }
        $websiteUrl = $oWebsite->website; 
    }

    function getWebsiteId($affiliateId, $autoGenerate = true)
    {
        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId);

        if (empty($oWebsitePref->website_id) && $autoGenerate) {
            $oWebsite = & OA_Dal::factoryDO('affiliates');
            $oWebsite->get($affiliateId);

            $websiteId = $this->generateWebsiteId($oWebsite->website);
            if (!empty($websiteId)) {
                $this->setWebsiteId($affiliateId, $websiteId);
            } else {
                return false;
            }
        } else {
            $websiteId = $oWebsitePref->website_id;
        }

        return $websiteId;
    }
    

    function generateWebsiteId($websiteUrl)
    {
        return $this->oMarketPublisherClient->newWebsite($websiteUrl);
    }
    

    function setAccountId($publisherAccountId)
    {
        $oAccountMapping = & OA_Dal::factoryDO('ext_market_assoc_data');
        $oAccountMapping->get('account_id', OA_Dal_ApplicationVariables::get('admin_account_id'));
        $oAccountMapping->publisher_account_id = $publisherAccountId;
        $oAccountMapping->save();
    }
    

    function setWebsiteId($affiliateId, $websiteId)
    {
        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId);
        $oWebsitePref->website_id = $websiteId;
        $oWebsitePref->save();
    }


    function checkIfFloorPriceRequired($submitValues)
    {
        if ($submitValues['mkt_is_enabled'] == 't') {
            if (trim($submitValues['floor_price']) == '') {
                return array('floor_price' => $this->translate('%s is required', array($this->translate('Campaign floor price'))));
            }
        }
        return true;
    }
    

    function afterLogin()
    {
        if (!$this->isActive()) {
            return;
        }
        
        // Only splash for Manager accounts
        if (OA_Permission::isUserLinkedToAdmin() && !$this->splashAlreadyShown()) {
            OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-info.php');
            //TODO set splash shown
            exit;
        }
    }

    
    function storeWebsiteRestrictions($affiliateId, $aType, $aAttribute, $aCategory)
    {
        if (!$this->isActive()) {
            return;
        }
        
        //  first remove all existing settings for $affiliateId
        $this->removeWebsiteRestrictions($affiliateId);
        $aData = array(
            SETTING_TYPE_CREATIVE_ATTRIB => $aAttribute,
            SETTING_TYPE_CREATIVE_CATEGORY => $aCategory,
            SETTING_TYPE_CREATIVE_TYPE => $aType
        );

        foreach($aData as $settingTypeId => $aValue) {
            if (empty($aValue)) {
                continue;
            }
            foreach ($aValue as $id) {
                $oMarketSetting = &OA_Dal::factoryDO('ext_market_setting');
                $oMarketSetting->market_setting_id = $id;
                $oMarketSetting->market_setting_type_id = $settingTypeId;
                $oMarketSetting->owner_type_id = OWNER_TYPE_AFFILIATE;
                $oMarketSetting->owner_id = $affiliateId;
                $oMarketSetting->insert();
            }
        }
        return true;
    }
    

    function removeWebsiteRestrictions($affiliateId)
    {
        $oMarketSetting = &OA_Dal::factoryDO('ext_market_setting');
        $oMarketSetting->owner_type_id = OWNER_TYPE_AFFILIATE;
        $oMarketSetting->owner_id = $affiliateId;
        $oMarketSetting->delete();
    }
    

    function updateWebsiteRestrictions($affiliateId, $aType, $aAttribute, $aCategory)
    {
        $websiteId = null; 
        $websiteUrl = null;
        $this->getWebsiteIdAndUrl($affiliateId, true, $websiteId, $websiteUrl);
        return $this->oMarketPublisherClient->updateWebsite($websiteId, 
            $websiteUrl, array_values($aAttribute), array_values($aCategory), 
            array_values($aType));
    }
    

    function getWebsiteRestrictions($affiliateId)
    {
        $oMarketSetting = &OA_Dal::factoryDO('ext_market_setting');
        $oMarketSetting->owner_type_id = OWNER_TYPE_AFFILIATE;
        $oMarketSetting->owner_id = $affiliateId;
        $aMarketSetting = $oMarketSetting->getAll();
        $aData = array(
                    SETTING_TYPE_CREATIVE_TYPE=>array(), 
                    SETTING_TYPE_CREATIVE_ATTRIB=>array(), 
                    SETTING_TYPE_CREATIVE_CATEGORY=>array()
                 );

        foreach ($aMarketSetting as $aValue) {
            $aData[$aValue['market_setting_type_id']][$aValue['market_setting_id']] = $aValue['market_setting_id'];
        }

        return $aData;
    }
    
    
    function isRegistered()
    {
        return $this->oMarketPublisherClient->hasAssociationWithPc();
    }
    
    
    function isActive()
    {
        return $this->isRegistered() && 
               ($this->oMarketPublisherClient->getAssociationWithPcStatus() == 
                    Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS);
    }
    
    
    function splashAlreadyShown()
    {
        //TODO get info about splash from DB
        return false;
    }
    
    
    function getInactiveStatus()
    {
        //TODO get from DB
        //TODO do we need a message returned from server as well?
        return array('code' => 0, 'message' => 
            'TODO: This is sample message! Account disabled due to a breach of OpenX Market terms and conditions');    
    }
    
    
    function getConfigValue($configKey)
    {
        return $GLOBALS['_MAX']['CONF']['oxMarket'][$configKey];
    }

    
    function checkRegistered($desiredStatus = true)
    {
        if ($desiredStatus != $this->isRegistered()) {
            OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-index.php');
        }
    }
    
    
    function checkActive($desiredStatus = true)
    {
        if ($desiredStatus != $this->isActive()) {
            OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-index.php');
        }
    }
    
    
    function createMenuForPubconsolePage($sectionId)
    {
        
        if (!$this->isRegistered() || !$this->isActive()) {
            return null;
        }
        
        $url = $GLOBALS['_MAX']['CONF']['oxMarket']['marketHost'];
        //add / if missing
        $url = (strrpos($url, "/") === strlen($url) - 1) ? $url : $url."/";
        $url.= "market/index/menu/?";
        if (!empty($sectionId)) {
            $id = urlencode($sectionId); //encode id for special characters eg. spaces    
            $url.= "id=$sectionId&";           
        }
        $pubAccountId = $this->getAccountId();
        $url.= $this->getConfigValue('marketAccountIdParamName')."=".$pubAccountId;
        
        $result = @file_get_contents($url);
        if (false === $result) {
            //TODO log error in file (no menu)
            return;
        }
        
        $oJson = new Services_JSON();
        $pubconsoleNav = $oJson->decode($result);
        
        if ($pubconsoleNav === null) {
            return null;
        }
        
        $pageName = $pubconsoleNav->pageName;
        $leftMenu = $pubconsoleNav->leftMenu;
        
        if ($leftMenu && is_array($leftMenu)) {
            $page = 'plugins/' . $this->group . '/market-include.php';
            foreach ($leftMenu as $entry) {
                $id = $entry->id;
                $name = $entry->name;
                $url = $entry->url;
                $isActive = $entry->active; 
                
                addLeftMenuSubItem($id, $name, "$page?p_url=$url");
                if ($isActive) {
                    setCurrentLeftMenuSubItem($id);            
                }
            }
        }
        
        return $pageName; //might be null we do not care
    }
    
    
    //UI actions
    function indexAction()
    {
        //TODO check activation status
        $registered = $this->isRegistered();
        $active = $this->isActive();
        
        if ($registered) {
            if ($active) {
                OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-include.php');
            }
            else {
                OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-inactive.php');
            }
        }
        else {
            if ($this->splashAlreadyShown()) {
                OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-signup.php');
            }
            else {
                OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-info.php');
            }
        }
    }
    
    /**
     * Returns Publisher Console API Client
     *
     * @return Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
     */
    function getPublisherConsoleApiClient() 
    {
        if (empty($this->oPubConsoleApiClient)) 
        { 
            $this->oPubConsoleApiClient = new Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient();
        }
        return $this->oPubConsoleApiClient;
    }
    
    /**
     * Update or register all websites
     * Silent skip problems (will try again in maintenance)
     *
     */
    function updateAllWebsites()
    {
        if (!$this->isRegistered() || !$this->isActive()) {
            return;
        }
        
        $oWebsite = & OA_Dal::factoryDO('affiliates');
        $oWebsite->find();
        while($oWebsite->fetch()) {
            try {
                $affiliateId = $oWebsite->affiliateid;
                $websiteId = $this->getWebsiteId($affiliateId, false);
                $websiteUrl = $oWebsite->website;
                if (empty($websiteId)) {
                    if ($websiteId = $this->generateWebsiteId($websiteUrl)) {
                        $this->setWebsiteId($affiliateId, $websiteId);
                        $restricted = $this->insertDefaultRestrictions($affiliateId);
                    }
                } else {
                    $result = $this->updateWebsiteUrl($affiliateId, $websiteUrl);
                    if ($result!==true) {
                        throw new Exception($result);
                    }
                }
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during updating website #'.$affiliateId.' : '.$e->getMessage());
            }
        }
    }
    
    /**
     * Updates website url on PubConsole
     *
     * @param int $affiliateId Affiliate Id
     * @param string $url New website url
     * @return boolean|string true or error message
     */
    function updateWebsiteUrl($affiliateId, $url) {
        $doWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsitePref->get($affiliateId);
        
        if (empty($doWebsitePref->website_id)) {
            $error = 'website not regisetered';
        } else {
            try {
                $aRestrictions = $this->getWebsiteRestrictions($affiliateId);
                $this->oMarketPublisherClient->
                    updateWebsite($doWebsitePref->website_id, $url, 
                                  $aRestrictions[SETTING_TYPE_CREATIVE_ATTRIB],
                                  $aRestrictions[SETTING_TYPE_CREATIVE_CATEGORY],
                                  $aRestrictions[SETTING_TYPE_CREATIVE_TYPE]);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            $doWebsitePref->is_url_synchronized = (!isset($error)) ? 't' : 'f';
            $doWebsitePref->update();  
        }
        return (!isset($error)) ? true : $error;
    }

    function runTasksAfterPluginEnable()
    {
        parent::runTasksAfterPluginEnable();
        $this->updateAllWebsites();
    }
}

?>
