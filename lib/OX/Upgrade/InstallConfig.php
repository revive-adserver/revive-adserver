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
$Id: InstallConfig.php 42760 2009-09-07 14:04:01Z lukasz.wikierski $
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