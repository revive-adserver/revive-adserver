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

/**
 * Implements functions required by new upgrader/installer
 *
 * @package    openXMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_Installer
{
    

    /**
     * Is registration required during upgrading/install process?
     *
     * @return bool
     */
    static public function isRegistrationRequired()
    {
        $oAccountAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $result = $oAccountAssocData->count();
        return ($result==0);
    }
    
    
    /**
     * Register admin (or default manager in multiple account mode) to the market
     * Use data given in registration step 
     * 
     * @param Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient $marketClient
     * @return boolean true if there was autoregistration to the market 
     * @throws Plugins_admin_oxMarket_PublisherConsoleClientException
     */
    static public function autoRegisterMarketPlugin(Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient &$marketClient)
    {
        // proceed only if registration is required
        $result = false;
        if (isset($marketClient) && self::isRegistrationRequired()){
            // get data from application variables
            require_once MAX_PATH . '/lib/OX/Dal/Market/MarketPluginTools.php';
            $aRegData = OX_Dal_Market_MarketPluginTools::getMarketAccountAssocData();
            if (isset($aRegData)) {
                if ($marketClient->isMultipleAccountsMode()) {
                    // select admin user
                    $doUser =  OA_Dal::factoryDO('users');
                    $doUserAssoc = OA_Dal::factoryDO('account_user_assoc');
                    $doUserAssoc->account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
                    $doUser->joinAdd($doUserAssoc);
                    $doUser->find();
                    if ($doUser->fetch()) {
                        // select Default Manager agency
                        $doAgency = OA_Dal::factoryDO('agency');
                        $doAccount = OA_Dal::factoryDO('accounts');
                        $doAccount->account_id = $doUser->default_account_id;
                        $doAgency->joinAdd($doAccount);
                        $doAgency->name = 'Default manager'; // this will work only on fresh install
                        $doAgency->find();
                        if ($doAgency->fetch()) {
                            $marketClient->setWorkAsAccountId($doAgency->account_id);
                            // agency has been found - proceed
                            $result = true;
                        }
                    }
                } else {
                    // single account mode - proceed
                    $result = true;
                }
                // no problem detected (account found etc.) 
                if ($result) { 
                    // assign publisher_account_id and api_key
                    if(!empty($aRegData['accountUuid'])
                        && !empty($aRegData['apiKey'])) {
                            $marketClient->setNewPublisherAccount($aRegData['accountUuid'], $aRegData['apiKey']);
                            // clear work as account if set
                            $marketClient->setWorkAsAccountId();
                        } else {
                            $result = false;
                        }
                }
            }
        }
        return $result;
    }

}
