<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Config
{
    var $conf;
    var $backupFilename;

     /**
     * The constructor method. Stores the current parse result of the
     * configuration .ini file so that it can be (locally) modified.
     */
    function OA_Admin_Config($isNewConfig = false)
    {
        if($isNewConfig) {
            $this->conf = array();
        } else {
            $this->conf = $GLOBALS['_MAX']['CONF'];
        }
    }

    /**
     * A method to test if the Openads configuration .ini file is writable by
     * the web server process.
     *
     * @static
     * @param string $configFile  Path to the config file
     * @param boolean $checkDir
     * @return boolean True if file is writable else method is checking
     *                 if directory is writable (if $checkDir is true)
     *                 else return false
     */
    function isConfigWritable($configFile = null, $checkDir = true)
    {
        if (!$configFile) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $url = @parse_url('http://' . $conf['webpath']['delivery']);
            $configFile = MAX_PATH . '/var/' . $url['host'] . '.conf.php';
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

    /**
     * A method for defining bulk required changes to the Openads configuration
     * .ini file.
     *
     * @param string $levelKey The top level of the item in the .ini file.
     * @param array $value The new values for the item.
     */
    function setBulkConfigChange($levelKey, $value)
    {
        $this->conf[$levelKey] = $value;
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
        $mainConfigFile = $configPath . '/' . $newDeliveryHost . $configFile . '.conf.php';
        if (!OA_Admin_Config::isConfigWritable($mainConfigFile)) {
            return false;
        }
        $c = new Config();
        $cc = &$c->parseConfig($this->conf, 'phpArray');
        $cc->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
        $cc->createComment('<'.'?php exit; ?>', 'top');
        if (!$c->writeConfig($mainConfigFile, 'IniCommented')) {
            return false;
        }
        // Check if a different host name is used for the admin
        if ($newAdminHost != $newDeliveryHost) {
            // Write out the new "fake" configuration file
            $file = $configPath . '/' . $newAdminHost . $configFile . '.conf.php';
            if (!OA_Admin_Config::isConfigWritable($file)) {
                return false;
            }
            $config = array('realConfig' => $newDeliveryHost);
            $c = new Config();
            $cc = &$c->parseConfig($config, 'phpArray');
            $cc->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
            $cc->createComment('<'.'?php exit; ?>', 'top');
            if (!$c->writeConfig($file, 'IniCommented')) {
                return false;
            }
        }
        // Check if a different host name is used for the delivery SSL
        if ($newDeliverySslHost != $newDeliveryHost) {
            // Write out the new "fake" configuration file
            $file = $configPath . '/' . $newDeliverySslHost . $configFile . '.conf.php';
            if (!OA_Admin_Config::isConfigWritable($file)) {
                return false;
            }
            $config = array('realConfig' => $newDeliveryHost);
            $c = new Config();
            $cc = &$c->parseConfig($config, 'phpArray');
            $cc->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
            $cc->createComment('<'.'?php exit; ?>', 'top');
            if (!$c->writeConfig($file, 'IniCommented')) {
                return false;
            }
        }
        // Always touch the INSTALLED file
        if (!touch(MAX_PATH . '/var/INSTALLED')) {
            return false;
        }
        // Do any old configuration files need to be deleted?
        if ($newAdminHost != $oldAdminHost) {
            $file = $configPath . '/' . $oldAdminHost . $configFile . '.conf.php';
            if($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        if ($newDeliveryHost != $oldDeliveryHost && $oldDeliveryHost != $newAdminHost) {
            $file = $configPath . '/' . $oldDeliveryHost . $configFile . '.conf.php';
            if($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        if ($newDeliverySslHost != $oldDeliverySslHost && $oldDeliverySslHost != $newAdminHost) {
            $file = $configPath . '/' . $oldDeliverySslHost . $configFile . '.conf.php';
            if($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        // Re-parse the config file?
        if ($reParse) {
            $file = $configPath . '/' . $newDeliveryHost . $configFile . '.conf.php';
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
     * Merges any changes in dist.conf.php into $this->conf.
     *
     * @param string $distConfig the full path to the distributed conf file.
     * @return true if changes successfully merged. Otherwise, false.
     *
     */
    function mergeConfigChanges($distConfig = null)
    {
        if (is_null($distConfig)) {
            $distConfig = MAX_PATH . '/etc/dist.conf.php';
        }

        if (!is_readable($distConfig)) {
            return false;
        }

        $aDistConf = @parse_ini_file($distConfig, true);

        // Check for deprecated keys to remove from existing user conf
        foreach ($this->conf as $key => $value) {
        	if (array_key_exists($key, $aDistConf)) {
        	    foreach ($this->conf[$key] as $subKey => $subValue) {
        	        if (!array_key_exists($subKey, $aDistConf[$key])) {
                        unset($this->conf[$key][$subKey]);
        	        }
        	    }
        	} else {
                unset($this->conf[$key]);
        	}
        }

        // Check for new keys in dist to add to existing user conf
        foreach ($aDistConf as $key => $value) {
        	if (array_key_exists($key, $this->conf)) {
        	    foreach ($aDistConf[$key] as $subKey => $subValue) {
        	    	if (!array_key_exists($subKey, $this->conf[$key])) {
                        $this->conf[$key][$subKey] = $subValue;
        	    	}
        	    }
        	} else {
                $this->conf[$key] = $value;
        	}
        }

        return true;
    }

    /**
     * Makes a backup copy of the given file if it exists.
     *
     * @param string $configFile full path to the file to be backed up.
     * @return boolean true if the file is successfully backed up. Otherwise, false.
     */
    function backupConfig($configFile)
    {
        // Backup user's original config file
        if (file_exists($configFile)) {
            $this->backupFilename = $this->_getBackupFilename($configFile);
            if (substr($configFile, -4) == '.ini') {
                // Add a PHP exit comment to ini files
                $phpComment = ';<'.'?php exit; ?>';
                $iniFile = file_get_contents($configFile);
                if (strpos($iniFile, $phpComment) !== 0) {
                    $iniFile = $phpComment."\r\n".$iniFile;
                }
                if ($fp = fopen($configFile, 'w')) {
                    if (fwrite($fp, $iniFile)) {
                        fclose($fp);
                    }
                }
            }
            return (copy($configFile, dirname($configFile) . '/' . $this->backupFilename));
        }

        return false;
    }

    /**
     * Generates a unique filename for the backup config file.
     *
     * @param string $filename the full path of the file to generate a backup filename for.
     * @return string the new filename in format: "old.original.name-YYYYMMDD[_0]"
     */
    function _getBackupFilename($filename)
    {
        $directory = dirname($filename);
        $basename = basename($filename);

        if (substr($basename, -4) == '.ini') {
            $basename .= '.php';
        }

        $now = date("Ymd");
        $newFilename =  $now.'_old.' . $basename;

        // Make sure we don't overwrite any old backup files.
        $i=0;
        while(file_exists($directory . '/' . $newFilename)){
            $newFilename = substr($newFilename, 0, strpos($newFilename, $now)) . $now . '_' . $i.'_old.'.$basename;
            $i++;
        }

        return $newFilename;
    }
}
?>