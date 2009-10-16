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
$Id: MarketClientFactory.php 43022 2009-09-11 12:37:56Z bernard.lange $
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