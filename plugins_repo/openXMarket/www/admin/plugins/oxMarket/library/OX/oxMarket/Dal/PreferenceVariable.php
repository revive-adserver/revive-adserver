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
