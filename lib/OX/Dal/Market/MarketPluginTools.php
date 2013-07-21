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