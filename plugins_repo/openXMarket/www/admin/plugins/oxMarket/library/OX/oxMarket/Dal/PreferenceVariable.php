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
 * Market user variables/account settings DAL
 *
 * @package    openXMarket
 * @author     Bernard Lange  <bernard.lange@openx.org>
 */
class OX_oxMarket_Dal_PreferenceVariable
{
    /**
     * @var Plugins_admin_oxMarket_oxMarket
     */
    protected $oMarketPlugin;
    
    
    public function __construct(Plugins_admin_oxMarket_oxMarket $oMarketPlugin)
    {
        $this->oMarketPlugin = $oMarketPlugin;
    }    
    
    
    /**
     * Sets market related preference for current market account.
     *
     * @param string $name
     * @param string $value
     */
    public function setMarketAccountPreference($name, $value)
    {
        $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
        $accountId = $this->oMarketPlugin->oMarketPublisherClient->getAccountId();
        $oPluginSettings->insertOrUpdateValue($accountId, $name, $value);        
    }

    
    /**
     * Gets market related preference for current market account.
     *
     * @param string $name
     * @return string value or null if not set
     */    
    public function getMarketAccountPreference($name)
    {
        $accountId = $this->oMarketPlugin->oMarketPublisherClient->getAccountId();
        $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
        return $oPluginSettings->findAndGetValue($accountId, $name);        
    }
    
    
    /**
     * Sets market variable for current user retrieved from OA::Permission
     *
     * @param string $name
     * @param string $value
     */
    public function setMarketUserVariable($name, $value)
    {
        $oMarketPluginVariable = OA_Dal::factoryDO('ext_market_plugin_variable');
        $oMarketPluginVariable->insertOrUpdateValue(
            intval(OA_Permission::getUserId()), $name, $value);
    }   

    
    /**
     * Gets market variable for current user retrieved from OA::Permission
     *
     * @param string $name
     * @return string value or null if not set
     **/
    public function getMarketUserVariable($name)
    {
        $oMarketPluginVariable = OA_Dal::factoryDO('ext_market_plugin_variable');
        $value = $oMarketPluginVariable->findAndGetValue(
            intval(OA_Permission::getUserId()), $name);
            
        return $value;         
    }    
    
}
