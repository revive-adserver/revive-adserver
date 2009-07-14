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

require_once LIB_PATH.'/Plugin/Component.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';

require_once LIB_PATH . '/Admin/Redirect.php';

require_once MAX_PATH. '/lib/JSON/JSON.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/NotificationManager.php';
require_once MAX_PATH . '/lib/OA.php';

require_once dirname(__FILE__) . '/var/config.php';
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
    protected $aDefaultRestrictions;

    /**
     * @var Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
     */
    public $oMarketPublisherClient;

    function __construct()
    {
        $this->oMarketPublisherClient =
            new Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient();
    }
    

    function afterPricingFormSection(&$form, $campaign, $newCampaign)
    {
        if (!$this->isActive()) {
            $this->afterPricingFormSectionForInactive($form, $campaign, $newCampaign);
            return;
        }

        $aConf = $GLOBALS['_MAX']['CONF'];

        $defaultFloorPrice = !empty($aConf['oxMarket']['defaultFloorPrice'])
            ? (float) $aConf['oxMarket']['defaultFloorPrice']
            : NULL;
        $defaultFloorPrice = $this->formatCpm($defaultFloorPrice);            
        $maxFloorPriceValue = $this->getMaxFloorPrice();

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
        $aFields['floor_price'] = $this->formatCpm($aFields['floor_price']);

        $form->addElement ( 'header', 'h_marketplace', "Maximize Ad Revenue");

        $aMktEnableGroup[] = $form->createElement('advcheckbox', 'mkt_is_enabled', null, $this->translate("Allow OpenX Market to show ads for this campaign if it beats the CPM below (RECOMMENDED)"), array('id' => 'enable_mktplace'), array("f", "t"));
        $aMktEnableGroup[] = $form->createElement('plugin-custom', 'market-callout', 'oxMarket');
        $form->addGroup($aMktEnableGroup, 'mkt_enabled_group', null);

        $aFloorPrice[] = $form->createElement('html', 'floor_price_label', $this->translate("Serve an ad from OpenX Market if it pays higher than this CPM &nbsp;&nbsp;$"));
        $aFloorPrice[] = $form->createElement('text', 'floor_price', null, array('class' => 'x-small', 'id' => 'floor_price', 'maxlength' => 3 + strlen($maxFloorPriceValue)));
        $aFloorPrice[] = $form->createElement('static', 'floor_price_usd', $this->translate("USD"));
        $form->addGroup($aFloorPrice, 'floor_price_group', '');
        $form->addElement('plugin-script', 'campaign-script', 'oxMarket', array('defaultFloorPrice' => $defaultFloorPrice));


        //in order to get conditional validation, check if it is POST 
        //and if market was enabled and add group rules
        if (isset($_POST['mkt_is_enabled']) && $_POST['mkt_is_enabled'] == 't') { 
            //Form validation rules
            $form->addGroupRule('floor_price_group', array(
                'floor_price' => array(
                    array($this->translate('%s is required', array($this->translate('Campaign floor price'))), 'required'),
                    array($this->translate("%s must be a minimum of at least 0.01", array($this->translate('Campaign floor price'))), 'min', 0.01),
                    array($this->translate("Must be a decimal with maximum %s decimal places", array('2')), 'decimalplaces', 2),
                    array($this->translate("%s must be smaller than %s", array('Campaign floor price', $maxFloorPriceValue)), 'max', $maxFloorPriceValue)
                )
            ));
        }

        $form->setDefaults($aFields);
    }


    function afterPricingFormSectionForInactive(&$form, $campaign, $newCampaign)
    {
        $oUI = OA_Admin_UI::getInstance();
        $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css'));

        $form->addElement ( 'header', 'h_marketplace', "Maximize Ad Revenue");

        if (OA_Permission::isUserLinkedToAdmin()) {
            $url = MAX::constructURL(MAX_URL_ADMIN, 'plugins/' . $this->group . '/market-info.php');
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


    function buildAdminEmail()
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


    function getAdminEmails()
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


    function processCampaignForm(&$aFields)
    {
        if (!$this->isActive()) {
            return;
        }

        $aConf = $GLOBALS['_MAX']['CONF'];

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
        if (!function_exists('OX_cacheInvalidateGetCampaignMarketInfo')) {
            require_once MAX_PATH . $aConf['pluginPaths']['plugins'] . 'deliveryAdRender/oxMarketDelivery/oxMarketDelivery.delivery.php';
        }
        OX_cacheInvalidateGetCampaignMarketInfo($aFields['campaignid']);
    }


    /**
     * Set default restriction to given website
     *
     * @param int $affiliateId
     * @return boolean
     */
    function insertDefaultRestrictions($affiliateId)
    {
        if (!isset($this->aDefaultRestrictions)) {
            $aDefRestr = $this->oMarketPublisherClient->getDefaultRestrictions();
            $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB] = $aDefRestr['attribute'];
            $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY] = $aDefRestr['category'];
            $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE] = $aDefRestr['type'];
        }
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
                try {
                    $websiteId = $this->generateWebsiteId($websiteUrl);
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
                        $result = $this->updateWebsiteUrl($affiliateId, $websiteUrl, false);
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
            try {
                $websiteId = $this->generateWebsiteId($oWebsite->website);
                if (!empty($websiteId)) {
                    $this->setWebsiteId($affiliateId, $websiteId);
                }
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during register website in OpenX Market : '.$e->getMessage());
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

            try {
                $websiteId = $this->generateWebsiteId($oWebsite->website);
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during register website in OpenX Market : '.$e->getMessage());
            }
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

    /**
     * generate website_id (singup website to market)
     *
     * @param string $websiteUrl
     * @return string website_id
     * @throws Plugins_admin_oxMarket_PublisherConsoleClientException
     * @throws Zend_Http_Client_FaultException
     */
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


    function getMaxFloorPrice()
    {
        return 1000000; //hardcoded value for validation purposes, such high 
                   //CPM does not make sense anyway, but we'd like to avoid 
                   //number overflows here
    }


    function afterLogin()
    {
        // If the user is manager or admin try to show him the OpenX Market Settings
        if ((OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) &&
            $this->isRegistered() && !$this->isMarketSettingsAlreadyShown()) {

            $this->setMarketSettingsAlreadyShown();
            OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-campaigns-settings.php');
            exit;
        }

        //show only to unregistered users and those who are linked to admin
        if ($this->isRegistered() || !OA_Permission::isUserLinkedToAdmin()) {

            return;
        }

        $this->scheduleRegisterNotification();

        // Only splash if not shown already
        if (empty($GLOBALS['installing']) && !$this->isSplashAlreadyShown()) {
            OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-info.php');
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

    /**
     * update website restrictions in OpenX Market
     *
     * @param int $affiliateId
     * @param array $aType
     * @param array $aAttribute
     * @param array $aCategory
     * @return boolean
     */
    function updateWebsiteRestrictions($affiliateId, $aType, $aAttribute, $aCategory)
    {
        $aType      = (is_array($aType)) ? array_values($aType) : array();
        $aAttribute = (is_array($aAttribute)) ? array_values($aAttribute) : array();
        $aCategory  = (is_array($aCategory)) ? array_values($aCategory) : array();
        $websiteId  = null;
        $websiteUrl = null;
        $this->getWebsiteIdAndUrl($affiliateId, true, $websiteId, $websiteUrl);
        try {
            $result = $this->oMarketPublisherClient->updateWebsite($websiteId,
                $websiteUrl, array_values($aAttribute), array_values($aCategory),
                array_values($aType));
        } catch (Exception $e) {
            OA::debug('openXMarket: Error during updating website restriction in OpenX Market : '.$e->getMessage());
            return false;
        }
        return (bool) $result;
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
        // Account is active if is registered, has valid status and API key is set
        $result = $this->isRegistered() &&
               ($this->oMarketPublisherClient->getAssociationWithPcStatus() ==
                    Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS);

        if ($result && !($this->oMarketPublisherClient->hasApiKey() == true))
        {
            // If only API key is missing, try recive this key automatically
            try {
                $this->oMarketPublisherClient->getApiKeyByM2MCred();
            } catch( Exception $e)
            {
                OA::debug('openXMarket: Error during reciving automatically API key : ('
                          .$e->getCode().') '.$e->getMessage());
            }
        }
        // Check if apikey is set
        return $result && ($this->oMarketPublisherClient->hasApiKey() == true);
    }


    function isSplashAlreadyShown()
    {
        return $GLOBALS['_MAX']['CONF']['oxMarket']['splashAlreadyShown'] == 1;
    }


    function setSplashAlreadyShown()
    {
            $oSettings = new OA_Admin_Settings();
            $oSettings->settingChange('oxMarket', 'splashAlreadyShown', 1);
            $oSettings->writeConfigChange();
    }

    function isMarketSettingsAlreadyShown()
    {
        $oMarketPluginVariable = & OA_Dal::factoryDO('ext_market_plugin_variable');
        $oMarketPluginVariable->user_id = intval(OA_Permission::getUserId());
        $oMarketPluginVariable->name = 'campaign_settings_shown_to_user';
        $oMarketPluginVariable->find();

        $marketSettingsShown = false;

        while($oMarketPluginVariable->fetch()) {
            $marketSettingsShown = $oMarketPluginVariable->value;
        }

        return $marketSettingsShown;
    }


    function setMarketSettingsAlreadyShown()
    {
        $oMarketPluginVariable = & OA_Dal::factoryDO('ext_market_plugin_variable');
        $oMarketPluginVariable->user_id = intval(OA_Permission::getUserId());
        $oMarketPluginVariable->name = 'campaign_settings_shown_to_user';
        $oMarketPluginVariable->value = '1';
        $oMarketPluginVariable->insert();
    }


    function isSsoUserNameAvailable($userName)
    {
        return $this->oMarketPublisherClient->isSsoUserNameAvailable($userName);
    }


    function getInactiveStatus()
    {
        if ($this->isActive()) {
            return null;
        }

        $hasApiKey = $this->oMarketPublisherClient->hasApiKey();
        $message = "OpenX Market publisher account is not properly associated with your ad server";
        if (!$hasApiKey) {
            $status = null;
            $message .= "<br>API Key is missing, please try re-connect your Ad Server to OpenX Market using your OpenX.org account";
        } else {
            $status = $this->oMarketPublisherClient->getAssociationWithPcStatus();
        }

        return array('code' => $status, 'message' => $message);
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

        //contact pubconsole and get the menu items
        $aPubconsoleNav = array();
        try {
            $menuUrl = $this->buildPubconsoleApiUrl($this->getConfigValue('marketMenuUrl'));
            $oClient = $this->getHttpClient();
            $oClient->setUri($menuUrl);

            $pubAccountId = $this->getAccountId();
            $aRequestParams =  array(
                $this->getConfigValue('marketAccountIdParamName') => $pubAccountId);
            if (!empty($sectionId)) {
                $id = urlencode($sectionId); //encode id for special characters eg. spaces and no xss
                $aRequestParams["id"] = $sectionId;
            }
            $oClient->setParameterGet($aRequestParams);

            $response = $oClient->request();
            if ($response->isSuccessful()) {
                $responseText = $response->getBody();
                $oJson = new Services_JSON();
                $aPubconsoleNav = $oJson->decode($responseText);
            }
        }
        catch(Exception $exc) {
            OA::debug('Error during retrieving menu items from pubconsole: ('.
                $exc->getCode().')'.$exc->getMessage());
        }

        //build local menu if not empty
        if (empty($aPubconsoleNav)) {
            return null;
        }

        $pageName = $aPubconsoleNav->pageName;
        $leftMenu = $aPubconsoleNav->leftMenu;
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
            OX_Admin_Redirect::redirect('plugins/' . $this->group . '/market-info.php');
        }
    }

    /**
     * Returns Publisher Console API Client
     *
     * @return Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
     */
    function getPublisherConsoleApiClient()
    {
        return $this->oMarketPublisherClient;
    }

    /**
     * Update or register all websites
     * Silent skip problems (will try again in maintenance)
     *
     * @param boolean $skip_synchonized In maintenace skip updating websites marked as url synchronized with marketplace
     *                                  other cases (e.g. reinstalling plugin and re-linking to market) should updates all websites
     * @param int $limitUpdatedWebsites Limit updated websites to this number, 0 - no limit
     */
    function updateAllWebsites($skip_synchonized = false, $limitUpdatedWebsites = 0)
    {
        if (!$this->isRegistered() || !$this->isActive()) {
            return;
        }
        $updatedWebsites = 0;

        $oWebsite = & OA_Dal::factoryDO('affiliates');
        $oWebsite->find();
        while($oWebsite->fetch() &&
              ($limitUpdatedWebsites==0 || $updatedWebsites<$limitUpdatedWebsites))
        {
            try {
                $affiliateId = $oWebsite->affiliateid;
                $websiteId = $this->getWebsiteId($affiliateId, false);
                $websiteUrl = $oWebsite->website;
                if (empty($websiteId)) {
                    if ($websiteId = $this->generateWebsiteId($websiteUrl)) {
                        $this->setWebsiteId($affiliateId, $websiteId);
                        $this->insertDefaultRestrictions($affiliateId);
                        $updatedWebsites++;
                    }
                } else {
                    $result = $this->updateWebsiteUrl($affiliateId, $websiteUrl,
                                            $skip_synchonized, $updatedWebsites);
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
     * @param boolean $skip_synchonized Skip updating if url is synchronized
     * @param int $updatedWebsites increase counter if website was updated
     * @return boolean|string true or error message
     */
    function updateWebsiteUrl($affiliateId, $url, $skip_synchonized = false, &$updatedWebsites = null) {
        $doWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsitePref->get($affiliateId);

        if (empty($doWebsitePref->website_id)) {
            $error = 'website not regisetered';
        } else {
            if (!$skip_synchonized || $doWebsitePref->is_url_synchronized !== 't') {
                try {
                        $aRestrictions = $this->getWebsiteRestrictions($affiliateId);
                        $this->oMarketPublisherClient->updateWebsite(
                            $doWebsitePref->website_id, $url,
                            array_values($aRestrictions[SETTING_TYPE_CREATIVE_ATTRIB]),
                            array_values(
                                $aRestrictions[SETTING_TYPE_CREATIVE_CATEGORY]),
                            array_values($aRestrictions[SETTING_TYPE_CREATIVE_TYPE]));
                } catch (Exception $e) {
                    $error = $e->getCode().':'.$e->getMessage();
                }
                $doWebsitePref->is_url_synchronized = (!isset($error)) ? 't' : 'f';
                $doWebsitePref->update();
                // Increase counter of updated websites
                if (isset($updatedWebsites)) {
                    $updatedWebsites++;
                }
            }
        }
        return (!isset($error)) ? true : $error;
    }

    /**
     * This method is called after install or enable
     * to update 10 websites (rest will be updated during maintenance)
     *
     */
    function initialUpdateWebsites()
    {
        // send 10 not updated websites
        $this->updateAllWebsites(true, 10);
    }


    function onEnable()
    {
        if (!$this->isRegistered()) {
            $this->scheduleRegisterNotification();
        }

        try {
            // Run registerwebsites script as background process
            $url = MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/market-run-registerwebsites.php');
            $ctx = stream_context_create(array('http' => array(
                   'method' => 'POST',
                   'header' => "Cookie: sessionID=".$_COOKIE['sessionID']."\r\n")));
            $fp = @fopen($url, 'rb', false, $ctx);
            if ($fp) {
                stream_set_timeout($fp, 1); // 1s timeout
                stream_get_contents($fp); 
            } else {
                // register 10 websites if can't run background script 
                $this->initialUpdateWebsites();
            }
        } catch (Exception $e) {
            OA::debug('oxMarket on Enable - exception occured: [' . $e->getCode() .'] '. $e->getMessage());
        }
        return true; // we allow to enable plugin
    }


    function onDisable()
    {
        $this->removeRegisterNotification();

        return true;
    }


    function scheduleRegisterNotification()
    {
        $oNotificationManager = OA_Admin_UI::getInstance()->getNotificationManager();
        $oNotificationManager->removeNotifications('oxMarketRegister'); //avoid duplicates

        $url = MAX::constructURL(MAX_URL_ADMIN, 'plugins/' . $this->group . '/market-index.php');

        $aContentKeys = $this->retrieveCustomContent('market-messages');

        $registerMessage = isset($aContentKeys['register-messsage'])
            ? vsprintf($aContentKeys['register-messsage'], array($url))
            : 'Earn more revenue by activating OpenX Market for your ad server.<br>
                <a href="'.$url.'">Get started now &raquo;</a>';

        $oNotificationManager->queueNotification($registerMessage, 'info', 'oxMarketRegister');
    }


    function updateSSLMessage()
    {
        if (!OX_oxMarket_Common_ConnectionUtils::isSSLAvailable()) {
            $this->scheduleNoSSLWarning();
        }
    }


    function scheduleNoSSLWarning()
    {
        $aContentKeys = $this->retrieveCustomContent('market-messages');

        $noSSLMessage = isset($aContentKeys['no-ssl-messsage'])
            ? $aContentKeys['no-ssl-messsage']
            : 'In order to secure your data, we recommend installing a PHP
                extension which supports secure connections (eg. cURL or OpenSSL).
                See <a href="http://www.openx.org/faq/market">OpenX Market FAQ</a>
                for more details.';

        OA_Admin_UI::queueMessage($noSSLMessage, 'local', 'warning', 0);
    }


    function removeRegisterNotification()
    {
        //clean up the bugging info message
        OA_Admin_UI::getInstance()->getNotificationManager()
            ->removeNotifications('oxMarketRegister');
    }


    function retrieveCustomContent($pageName)
    {
        require_once MAX_PATH.'/lib/Zend/Http/Client.php';

        $result = false;
        try {
            //connect to pubconsole API and get the custom content for that page
            $customContentUrl = $this->buildPubconsoleApiUrl($this->getConfigValue('marketCustomContentUrl'));
            $oClient = $this->getHttpClient();
            $oClient->setUri($customContentUrl);
            $oClient->setParameterGet(array(
                'pageName'  => urlencode($pageName),
                'adminWebUrl' => urlencode(MAX::constructURL(MAX_URL_ADMIN, '')),
                'pcWebUrl' => urlencode($this->getConfigValue('marketHost')),
                'v' => $this->getPluginVersion(),
                'h' => "0"
            ));

            $response = $oClient->request();
            if ($response->isSuccessful()) {
                $responseText = $response->getBody();
                $result = $this->parseCustomContent($responseText);
            }
        }
        catch(Exception $exc) {
            OA::debug('Error during retrieving custom content: ('.$exc->getCode().')'.$exc->getMessage());
        }

        return $result;
    }


    /**
     * Returns an array with key to value for custom content
     *
     * @param string $responseText
     * @return an array key=>value when parsing ok, false otherwise
     */
    function parseCustomContent($responseText)
    {
        require_once dirname(__FILE__) . '/XMLToArray.php';

        $xml2a = new XMLToArray();
        $aRoot = $xml2a->parse($responseText);
        $aContentStrings = array_shift($aRoot["_ELEMENTS"]);

        if ($aContentStrings['_NAME'] != 'contentStrings') {
            return false;
        }

        $aKeys = array();
        foreach ($aContentStrings["_ELEMENTS"] as $aContentString) {
             $aKeys[$aContentString['_NAME']] = $aContentString['_DATA'];
        }

        return $aKeys;
    }

    
    public function getPluginVersion()
    {
        $oPluginManager = new OX_PluginManager();
        $aInfo =  $oPluginManager->getPackageInfo('openXMarket', false);    
        return strtolower($aInfo['version']);        
    }    
    

    /**
     * Builds an url to pubconsole either SSL or HTTP fallback, apends suffix if given
     *
     * @param string $suffix - with no leading slash
     * @return string pubconsole url with suffix if given
     */
    function buildPubconsoleApiUrl($suffix = null)
    {
        if (OX_oxMarket_Common_ConnectionUtils::isSSLAvailable()) {
            $pubconsoleLink = $this->getConfigValue('marketPcApiHost');
        }
        else {
            $pubconsoleLink = $this->getConfigValue('fallbackPcApiHost');
        }
        if (!empty($suffix)) {
            $pubconsoleLink = $pubconsoleLink .'/'. $suffix;
        }

        return $pubconsoleLink;
    }


    /**
     * Creates a client with proper attributes and settinngs (like cUrl handling etc)
     * already configured.
     * By default timeout is 30 secs and 5 redirects are allowed.
     *
     */
    function getHttpClient()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $curlAllowAnyCertificate = false;
        if (array_key_exists('curlAllowAnyCertificate',$aConf['oxMarket'])) {
            $curlAllowAnyCertificate = $aConf['oxMarket']['curlAllowAnyCertificate'];
        }
        $oClient = OX_oxMarket_Common_ConnectionUtils::factoryGetZendHttpClient($curlAllowAnyCertificate);
        $oClient->setConfig(array(
            'maxredirects' => 5,
            'timeout'      => 30));


        return $oClient;
    }


    /**
     * Synchronize status with market and return new status
     *
     * @return int|bool status code, or false if client isn't registered
     */
    function updateAccountStatus()
    {
        if ($this->isRegistered()) {
            return $this->oMarketPublisherClient->updateAccountStatus();
        } else {
            return false;
        }
    }
    
    
    function formatCpm($cpm)
    {
        return number_format($cpm, 2, '.', '');
    }    
}

?>
