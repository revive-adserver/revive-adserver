<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

require_once 'Config.php';

/**
 * A configuration management class for the Openads administration interface.
 *
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Admin_Config
{
    var $conf;

    /**
     * The constructor method. Stores the current parse result of the
     * configuration .ini file so that it can be (locally) modified.
     */
    function MAX_Admin_Config($isNewConfig = false)
    {
        if($isNewConfig) {
            $this->conf = array();
        } else {
            $this->conf = $GLOBALS['_MAX']['CONF'];
        }
    }

    /**
     * A method for defining required changes to the Openads configuration .ini
     * file.
     *
     * @param string $levelKey The top level of the item in the .ini file.
     * @param string $itemKey The item level of the item in the .ini file
     *                        (under the top level).
     * @param string $value The new value for the item.
     */
    function setConfigChange($levelKey, $itemKey, $value)
    {
        $this->conf[$levelKey][$itemKey] = $value;
    }

    /**
     * A method for defining bulk required changes to the Openads configuration
     * .ini file.
     *
     * @param string $levelKey The top level of the item in the .ini file.
     * @param array $values The new values for the item.
     */
    function setBulkConfigChange($levelKey, $value)
    {
        $this->conf[$levelKey] = $value;
    }

    /**
     * A method for writing out required changes to Openads configuration .ini
     * files. Configuration files are prefixed with the host name being
     * used to access Openads, so that multiple Openads installations can be run
     * from a single code base, if the correct virtual hosts are configured.
     *
     * @param string $configPath The directory to save the config file(s) in.
     *                           Default is Max's /var directory.
     * @param string $configFile The configuration file name (eg. "geotargeting").
     *                           Default is no name (ie. the main Max
     *                           configuration file).
     * @param boolean $reParse   If the config file should be parsed again
     *                           after writing (default is true).
     *
     * @return boolean True when the configuration file(s) was (were)
     *                 correctly written out, false otherwise.
     */
    function writeConfigChange($configPath = null, $configFile = null, $reParse = true)
    {
        if (is_null($configPath)) {
            $configPath = MAX_PATH . '/var';
        }
        if (!is_null($configFile)) {
            $configFile = '.' . $configFile;
        }
        // What were the old host names used for the installation?
        $conf = $GLOBALS['_MAX']['CONF'];
        $url = @parse_url('http://' . $conf['webpath']['admin']);
        $oldAdminHost = $url['host'];
        $url = @parse_url('http://' . $conf['webpath']['delivery']);
        $oldDeliveryHost = $url['host'];
        $url = @parse_url('http://' . $conf['webpath']['deliverySSL']);
        $oldDeliverySslHost = $url['host'];
        // What are the new host names used for the installation?
        $url = @parse_url('http://' . $this->conf['webpath']['admin']);
        $newAdminHost = $url['host'];
        $url = @parse_url('http://' . $this->conf['webpath']['delivery']);
        $newDeliveryHost = $url['host'];
        $url = @parse_url('http://' . $this->conf['webpath']['deliverySSL']);
        $newDeliverySslHost = $url['host'];
        // Write out the new main configuration file
        $mainConfigFile = $configPath . '/' . $newDeliveryHost . $configFile . '.conf.ini';
        if (!MAX_Admin_Config::isConfigWritable($mainConfigFile)) {
            return false;
        }
        $c = new Config();
        $c->parseConfig($this->conf, 'phpArray');
        if (!$c->writeConfig($mainConfigFile, 'inifile')) {
            return false;
        }
        // Check if a different host name is used for the admin
        if ($newAdminHost != $newDeliveryHost) {
            // Write out the new "fake" configuration file
            $file = $configPath . '/' . $newAdminHost . $configFile . '.conf.ini';
            if (!MAX_Admin_Config::isConfigWritable($file)) {
                return false;
            }
            $config = array('realConfig' => $newDeliveryHost);
            $c = new Config();
            $c->parseConfig($config, 'phpArray');
            if (!$c->writeConfig($file, 'inifile')) {
                return false;
            }
        }
        // Check if a different host name is used for the delivery SSL
        if ($newDeliverySslHost != $newDeliveryHost) {
            // Write out the new "fake" configuration file
            $file = $configPath . '/' . $newDeliverySslHost . $configFile . '.conf.ini';
            if (!MAX_Admin_Config::isConfigWritable($file)) {
                return false;
            }
            $config = array('realConfig' => $newDeliveryHost);
            $c = new Config();
            $c->parseConfig($config, 'phpArray');
            if (!$c->writeConfig($file, 'inifile')) {
                return false;
            }
        }
        // Always touch the INSTALLED file
        if (!touch(MAX_PATH . '/var/INSTALLED')) {
            return false;
        }
        // Do any old configuration files need to be deleted?
        if ($newAdminHost != $oldAdminHost) {
            $file = $configPath . '/' . $oldAdminHost . $configFile . '.conf.ini';
            if($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        if ($newDeliveryHost != $oldDeliveryHost) {
            $file = $configPath . '/' . $oldDeliveryHost . $configFile . '.conf.ini';
            if($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        if ($newDeliverySslHost != $oldDeliverySslHost) {
            $file = $configPath . '/' . $oldDeliverySslHost . $configFile . '.conf.ini';
            if($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        // Re-parse the config file?
        if ($reParse) {
            $file = $configPath . '/' . $newDeliveryHost . $configFile . '.conf.ini';
            $GLOBALS['_MAX']['CONF'] = @parse_ini_file($file, true);
            $this->conf = $GLOBALS['_MAX']['CONF'];
            // Set the global $conf value -- normally set by the init
            // script -- to be the same as $GLOBALS['_MAX']['CONF']
            global $conf;
            $conf = $GLOBALS['_MAX']['CONF'];
        }
        return true;
    }

    /**
     * A method to test if the Openads configuration .ini file is writable by
     * the web server process.
     *
     * @static
     * @param string $configFile  Path to the config file
     * @return boolean True if file is writable else method is checking
     *                 if directory is writable (if $checkDir is true)
     *                 else return false
     */
    function isConfigWritable($configFile = null, $checkDir = true)
    {
        if (!$configFile) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $url = @parse_url('http://' . $conf['webpath']['delivery']);
            $configFile = MAX_PATH . '/var/' . $url['host'] . '.conf.ini';
        }
        if (file_exists($configFile)) {
            return is_writable($configFile);
        } elseif ($checkDir) {
            // Openads has not been installed yet (or plugin config file doesn't exists)
            // so need to test if the web
            // server can write to the config file directory
            $configDir = substr($configFile, 0, strrpos($configFile, '/'));
            return is_writable($configDir);
        } else {
            return false;
        }
    }

}

?>
