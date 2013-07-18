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

require_once MAX_PATH . '/lib/OX/Upgrade/InstallConfig.php';
require_once MAX_PATH . '/lib/OX/Upgrade/Util/PlatformHashManager.php';
require_once MAX_PATH . '/lib/OX/Dal/Market/RegistrationClient.php';

/**
 * Initialize market registration client in install/upgrade process
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_MarketClientFactory
{
    
    /**
     * @var OX_Dal_Market_RegistrationClient
     */
    private static $marketClient;
    
    
    /**
     * Gets platformhash and install config and creates market client
     * @param string $platformHash optional
     *   
     *
     * @return OX_Dal_Market_RegistrationClient
     */
    public static function getMarketClient($platformHash = null)
    {
        if (!isset(self::$marketClient)) {
            $config = OX_Upgrade_InstallConfig::getConfig();
            if (!isset($platformHash)) {
                $oPlatformHashManager = new OX_Upgrade_Util_PlatformHashManager();
                $platformHash = $oPlatformHashManager->getPlatformHash();
            }
            self::$marketClient = new OX_Dal_Market_RegistrationClient($config, $platformHash); 
        }
        return self::$marketClient;
    }
}