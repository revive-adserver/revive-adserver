<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id: MarketPluginTools.php 43248 2009-09-16 09:20:00Z bernard.lange $
*/
/**	
 * Utils to find market plugin, check if registration to PC is required,
 * methods to store in OXP database account association data (used later by market plugin)
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Dal_Market_MarketPluginTools
{

    
    /**
     * Returns oxMarket component or false if can't detect Market Plugin
     *
     * @return Plugins_admin_oxMarket_oxMarket or false if not detected
     */
    public static function getMarketPlugin()
    {
        // check if market plugin is installed
        if (isset($GLOBALS['_MAX']['CONF']['plugins']['openXMarket']))
        { 
            // check if can get marketplugin
            $oComponent = &OX_Component::factory('admin', 'oxMarket');        
            return $oComponent;
        }
        return false;
    }
    
    
    /**
     * Check if registration to the market is required
     *
     * @return bool true if registartion is required, false otherwise
     */
    public static function isRegistrationRequired()
    {
	    $registrationRequired = true;
        // check self::getMarketAccountAssocData() (could be failed installation?)
        $data = self::getMarketAccountAssocData();
        if (isset($data)) {
            $registrationRequired = false;
        } else {
			$registrationRequired = self::isMarketPluginEnabledOrRegistrationRequired();
        }
        return $registrationRequired;
    }
    
    public static function isMarketPluginEnabledOrRegistrationRequired()
	{
		// check if can get marketplugin
		$oMarketPlugin = self::getMarketPlugin();
		if (!$oMarketPlugin) {
			return true;
		}
		// check if there is method in market plugin isRegistrationRequired (since oxMarket 1.2)
		if (method_exists($oMarketPlugin, 'isRegistrationRequired')) {
			// yes: - use this method
			$registrationRequired = $oMarketPlugin->isRegistrationRequired();
		} else {
			// no: - check database of market plugin (what to do with multi account?)
			$oAccountAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
			$result = $oAccountAssocData->count();
			if ($result>0) {
				$registrationRequired = false;
			}
		}
		return $registrationRequired;
	}

    /**
     * Store account assoc data in application variables
     *
     * @param string $accountUuid
     * @param string $apiKey
     * @return bool True on success
     */
    public static function storeMarketAccountAssocData($accountUuid, $apiKey)
    {
        // store in application variable
        if( !PEAR::isError(OA_DB::singleton())) {
            return OA_Dal_ApplicationVariables::set('oxMarket_publisher_account_id', $accountUuid) &&
                   OA_Dal_ApplicationVariables::set('oxMarket_api_key', $apiKey);
        }
        return false;
    }

    
    /**
     * Get account assoc data from application variables
     *
     * @return array 'apiKey' and 'accountUuid' publisher account id or null if values are not set
     */
    public static function getMarketAccountAssocData()
    {
        // method used by market plugin during installation/upgrading to get stored in database data
        // get from application variable (return false if not registered)
        if( !PEAR::isError(OA_DB::singleton())) {
            $accountUuid = OA_Dal_ApplicationVariables::get('oxMarket_publisher_account_id');
            $apiKey = OA_Dal_ApplicationVariables::get('oxMarket_api_key');
            if (isset($accountUuid) && isset($apiKey)) {
                return array('apiKey' => $apiKey, 'accountUuid' => $accountUuid);            
            }
        }
        return null;
    }
    
}