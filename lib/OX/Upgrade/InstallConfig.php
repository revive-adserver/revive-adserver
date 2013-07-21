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
 * Reads and store install config
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_InstallConfig
{
    
    /**
     * @var array
     */
    private static $installConfig;
    
    
    /**
     * Get install section forom /etc/dist.conf.php config file
     * Returns empyt array if can't read dist.conf.php
     *
     * @return array install section of config file
     */
    public static function getConfig()
    {
        if (!isset(self::$installConfig)) {
            $config = @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', true);
            if (is_array($config) && array_key_exists('install', $config)) {
                self::$installConfig = $config['install'];
            } else {
                return array(); // empty settings on fail
            }
        }
        return self::$installConfig; 
    }
}