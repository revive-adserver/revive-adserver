<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Required files
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/pear/Config.php';

/**
 * A class for managing the OpenX settings configuration file(s).
 *
 * @package    OpenXAdmin
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Settings
{

    /**
     * A local array to store configuration file settings values.
     *
     * @var array
     */
    var $aConf;

    /**
     * The backup filename string.
     *
     * @var string
     */
    var $backupFilename;

    /**
     * The constructor method. Stores the current parse result of the
     * configuration .conf.php file so that it can be (locally) modified.
     */
    function OA_Admin_Settings($isNewConfig = false)
    {
        if ($isNewConfig) {
            $this->aConf = array();
        } else {
            $this->aConf = $GLOBALS['_MAX']['CONF'];
        }
    }

    /**
     * A method to return a reference to the configuration array.
     *
     * @return array The configuration array.
     */
    function &getConfigArray()
    {
        return $this->aConf;
    }

    /**
     * A method to test if the OpenX configuration .conf.php file is
     * writable by the web server process.
     *
     * Method is static so that it can be called without creating an
     * object instance in the event that other code simply wants to
     * know if the configuration .conf.php file is writable or not.
     *
     * @static
     * @param string $configFile The full configuration file name,
     *                           including the directory path.
     * @param boolean $isDir Test if the configration file directory is
     *                       writable instead? Set to true to test the
     *                       directory for the ability to write a
     *                       configuration file.
     * @return boolean True if the file or directory is writable, false
     *                 otherwise.
     */
    function isConfigWritable($configFile = null, $isDir = true)
    {
        if (!$configFile) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $url = @parse_url('http://' . $conf['webpath']['delivery']);
            $configFile = MAX_PATH . '/var/' . $url['host'] . '.conf.php';
        }
        if (file_exists($configFile)) {
            return is_writable($configFile);
        } elseif ($isDir) {
            // OpenX has not been installed yet (or plugin config file
            // doesn't exist) so need to test if the web server can write
            // to the config file directory
            $configDir = substr($configFile, 0, strrpos($configFile, '/'));
            return is_writable($configDir);
        } else {
            return false;
        }
    }

    /**
     * A method for making bulk changes to the configuration file object.
     *
     * @param string $levelKey The top level of the item in the configration file.
     * @param array $aValues An array of key/value pairs to set under the top
     *                       level item.
     */
    function bulkSettingChange($levelKey, $aValues)
    {
        $this->aConf[$levelKey] = $aValues;
    }

    /**
     * A method for making a single change to the configuration file object.
     *
     * @param string $levelKey The top level of the item in the configuration file.
     * @param string $itemKey The key name of the item in the configration file
     *                        (under the top level).
     * @param string $value The new value for the key.
     */
    function settingChange($levelKey, $itemKey, $value)
    {
        $this->aConf[$levelKey][$itemKey] = $value;
    }

    /**
     * A method for writing out the OpenX configuration .conf.php file(s),
     * including any changes that have been made to the configuration in the
     * current object.
     *
     * Configuration files are prefixed with the host name being used to access
     * Openads, so that multiple OpenX installations can be run from a single
     * code base, if the correct virtual hosts are configured.
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
        $aConf = $GLOBALS['_MAX']['CONF'];
        $url = @parse_url('http://' . $aConf['webpath']['admin']);
        $oldAdminHost = $url['host'];
        $url = @parse_url('http://' . $aConf['webpath']['delivery']);
        $oldDeliveryHost = $url['host'];
        $url = @parse_url('http://' . $aConf['webpath']['deliverySSL']);
        $oldDeliverySslHost = $url['host'];
        // What are the new host names used for the installation?
        $url = @parse_url('http://' . $this->aConf['webpath']['admin']);
        $newAdminHost = $url['host'];
        $url = @parse_url('http://' . $this->aConf['webpath']['delivery']);
        $newDeliveryHost = $url['host'];
        $url = @parse_url('http://' . $this->aConf['webpath']['deliverySSL']);
        $newDeliverySslHost = $url['host'];
        // Write out the new main configuration file
        $mainConfigFile = $configPath . '/' . $newDeliveryHost . $configFile . '.conf.php';
        if (!OA_Admin_Settings::isConfigWritable($mainConfigFile)) {
            return false;
        }
        $oConfig = new Config();
        $oConfigContainer =& $oConfig->parseConfig($this->aConf, 'phpArray');
        $oConfigContainer->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
        $oConfigContainer->createComment('<'.'?php exit; ?>', 'top');
        if (!$oConfig->writeConfig($mainConfigFile, 'IniCommented')) {
            return false;
        }
        // Check if a different host name is used for the admin
        if ($newAdminHost != $newDeliveryHost) {
            // Write out the new "fake" configuration file
            $file = $configPath . '/' . $newAdminHost . $configFile . '.conf.php';
            if (!OA_Admin_Settings::isConfigWritable($file)) {
                return false;
            }
            $aConfig = array('realConfig' => $newDeliveryHost);
            $oConfig = new Config();
            $oConfigContainer =& $oConfig->parseConfig($aConfig, 'phpArray');
            $oConfigContainer->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
            $oConfigContainer->createComment('<'.'?php exit; ?>', 'top');
            if (!$oConfig->writeConfig($file, 'IniCommented')) {
                return false;
            }
        }
        // Check if a different host name is used for the delivery SSL
        if ($newDeliverySslHost != $newDeliveryHost) {
            // Write out the new "fake" configuration file
            $file = $configPath . '/' . $newDeliverySslHost . $configFile . '.conf.php';
            if (!OA_Admin_Settings::isConfigWritable($file)) {
                return false;
            }
            $aConfig = array('realConfig' => $newDeliveryHost);
            $oConfig = new Config();
            $oConfigContainer =& $oConfig->parseConfig($aConfig, 'phpArray');
            $oConfigContainer->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
            $oConfigContainer->createComment('<'.'?php exit; ?>', 'top');
            if (!$oConfig->writeConfig($file, 'IniCommented')) {
                return false;
            }
        }
        // Always touch the INSTALLED file
        if (!touch(MAX_PATH . '/var/INSTALLED')) {
            return false;
        }
        // Do any old configuration files need to be deleted?
        if (!is_null($oldAdminHost) && ($newAdminHost != $oldAdminHost)) {
            $file = $configPath . '/' . $oldAdminHost . $configFile . '.conf.php';
            if ($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        if (!is_null($oldDeliveryHost) && ($newDeliveryHost != $oldDeliveryHost) && ($oldDeliveryHost != $newAdminHost)) {
            $file = $configPath . '/' . $oldDeliveryHost . $configFile . '.conf.php';
            if ($file != $mainConfigFile) {
                @unlink($file);
            }
        }
        if (!is_null($oldDeliverySslHost) && ($newDeliverySslHost != $oldDeliverySslHost) && ($oldDeliverySslHost != $newAdminHost)) {
            $file = $configPath . '/' . $oldDeliverySslHost . $configFile . '.conf.php';
            if ($file != $mainConfigFile) {
                @unlink($file);
            }
        }

        // If there are any un-accounted for config files in the var directory, don't write a default.conf.php file
        $aOtherConfigFiles = $this->findOtherConfigFiles($configPath, $configFile);
        if (empty($aOtherConfigFiles)) {
            $file = $configPath . '/default' . $configFile . '.conf.php';
            if (!OA_Admin_Settings::isConfigWritable($file)) {
                return false;
            }
            $aConfig = array('realConfig' => $newDeliveryHost);
            $oConfig = new Config();
            $oConfigContainer =& $oConfig->parseConfig($aConfig, 'phpArray');
            $oConfigContainer->createComment('*** DO NOT REMOVE THE LINE ABOVE ***', 'top');
            $oConfigContainer->createComment('<'.'?php exit; ?>', 'top');
            if (!$oConfig->writeConfig($file, 'IniCommented')) {
                return false;
            }
        } else {
            OA::debug('Did not create a default.conf.php file due to the presence of:' . implode(', ', $aOtherConfigFiles), PEAR_LOG_INFO);
        }
        // Re-parse the config file?
        if ($reParse) {
            $file = $configPath . '/' . $newDeliveryHost . $configFile . '.conf.php';
            $GLOBALS['_MAX']['CONF'] = @parse_ini_file($file, true);
            $this->aConf = $GLOBALS['_MAX']['CONF'];
            // Set the global $conf value -- normally set by the init
            // script -- to be the same as $GLOBALS['_MAX']['CONF']
            global $conf;
            $conf = $GLOBALS['_MAX']['CONF'];
        }
        return true;
    }

    /**
     * This method checks all the config files in a directory and returns an array of any config files
     * which cannot be identified as part of the current installation
     *
     * @param string $configPath The directory to save the config file(s) in.
     *                           Default is Max's /var directory.
     * @param string $configFile The configuration file name (eg. "geotargeting").
     *                           Default is no name (ie. the main Max
     *                           configuration file).
     * @return array An array of config file names which are not part of the current installation
     */
    function findOtherConfigFiles($configPath = null, $configFile = null)
    {

        if (!is_null($configPath) && is_dir($configPath)) {
            // Enumerate any valid config files for this installation
            $url = @parse_url('http://' . $this->aConf['webpath']['admin']);
            $hosts[] = $url['host'] . $configFile . '.conf.php';
            $url = @parse_url('http://' . $this->aConf['webpath']['delivery']);
            $hosts[] = $url['host'] . $configFile . '.conf.php';
            $url = @parse_url('http://' . $this->aConf['webpath']['deliverySSL']);
            $hosts[] = $url['host'] . $configFile . '.conf.php';

            $aFiles = array();
            $CONFIG_DIR = opendir($configPath);
            // Collect any "*.conf.php" files from the configPath folder
            while ($file = readdir($CONFIG_DIR)) {
                if ( // File is a .conf.php file
                    substr($file, strlen($file) - 9) == '.conf.php' &&
                    // File is not the test config file
                    ($file != 'test.conf.php') &&
                    // File is not a backup config file
                    (!preg_match('#[0-9]{8}(_[0-9]+)?_old.*conf.php#', $file)) &&
                    // File is not a valid config file for this domain
                    (!in_array($file, $hosts))
                ) {
                    $aFiles[] = $file;
                }
            }
            closedir($CONFIG_DIR);
            return $aFiles;
        }
    }

    /**
     * Merges any changes in dist.conf.php into $this->aConf.
     *
     * @param string $distConfig the full path to the distributed conf file.
     * @return boolean True if changes successfully merged, false otherwise.
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
        /**
         * WARNING: THIS ALSO REMOVES USER-DEFINED KEYS
         */
        /*foreach ($this->aConf as $key => $value) {
        	if (array_key_exists($key, $aDistConf)) {
        	    foreach ($this->aConf[$key] as $subKey => $subValue) {
        	        if (!array_key_exists($subKey, $aDistConf[$key])) {
                        unset($this->aConf[$key][$subKey]);
        	        }
        	    }
        	} else {
                unset($this->aConf[$key]);
        	}
        }*/

        // Check for new keys in dist to add to existing user conf
        foreach ($aDistConf as $key => $value) {
        	if (array_key_exists($key, $this->aConf)) {
        	    foreach ($aDistConf[$key] as $subKey => $subValue) {
        	    	if (!array_key_exists($subKey, $this->aConf[$key])) {
                        $this->aConf[$key][$subKey] = $subValue;
        	    	}
        	    }
        	} else {
                $this->aConf[$key] = $value;
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
        $i = 0;
        while (file_exists($directory . '/' . $newFilename)) {
            $newFilename = substr($newFilename, 0, strpos($newFilename, $now)) . $now . '_' . $i.'_old.'.$basename;
            $i++;
        }
        return $newFilename;
    }

    /**
     * A method for processing settings values from a UI form, and updating the settings
     * values in the configuration file.
     *
     * @param array $aElements An array of arrays, indexed by the HTML form element names,
     *                         and then the top level configuration file item, containing
     *                         the configuration file key.
     *
     *                         The inner array can also contain the fixed keys "preg_match"
     *                         and "preg_replace", and the values will be used as a preg
     *                         pattern on the actual value.
     *
     *                         The inner array can also contain the fixed key "bool", in
     *                         which case the value will be treated as a true/false
     *                         element from the HTML form.
     *
     *                         The inner array can also contain the fixed keys "preg_split"
     *                         and "merge", and the preg_split value will be used to split
     *                         the actual value into an array, and then remove any empty
     *                         values from the result, and then the resulting array will be
     *                         merged with the merge value, and stored.
     *
     *                         For example:
     *  array(
     *      delivery_cacheExpire => array(
     *                                  delivery     => acls
     *                                  preg_match   => #/$#
     *                                  preg_replace =>
     *                              )
     *  )
     *
     * This array would store the value from the "delivery_cacheExpire" HTML form element
     * in the configuration file under the [delivery] section, acls key; but the value stored
     * would have the "/" character, if it existed, removed from the end of the string value
     * stored.
     *
     * @return boolean True if the configuration file was saved correctly, false otherwise.
     */
    function processSettingsFromForm($aElementNames)
    {
        foreach ($aElementNames as $htmlElement => $aConfigInfo) {
            // Register the HTML element value
            MAX_commonRegisterGlobalsArray(array($htmlElement));
            // Was the HTML element value set?
            if (isset($GLOBALS[$htmlElement])) {
                reset ($aConfigInfo);
                if (isset($aConfigInfo['preg_match'])) {
                    $preg_match = $aConfigInfo['preg_match'];
                    unset($aConfigInfo['preg_match']);
                }
                if (isset($aConfigInfo['preg_replace'])) {
                    $preg_replace = $aConfigInfo['preg_replace'];
                    unset($aConfigInfo['preg_replace']);
                }
                $value = $GLOBALS[$htmlElement];
                if (isset($preg_match) && isset($preg_replace)) {
                    $value = preg_replace($preg_match, $preg_replace, $value);
                }
                unset($preg_match);
                unset($preg_replace);
                if (isset($aConfigInfo['bool'])) {
                    $value = 'true';
                }
                unset($aConfigInfo['bool']);
                if (isset($aConfigInfo['preg_split']) && isset($aConfigInfo['merge'])) {
                    $pregSplit = $aConfigInfo['preg_split'];
                    $merge = $aConfigInfo['merge'];
                    unset($aConfigInfo['preg_split']);
                    unset($aConfigInfo['merge']);
                    foreach ($aConfigInfo as $levelKey => $itemKey) {
                        $aValues = preg_split($pregSplit, $value);
                        $aEmptyKeys = array_keys($aValues, '');
                        $counter = -1;
                        foreach ($aEmptyKeys as $key) {
                            $counter++;
                            array_splice($aValues, $key - $counter, 1);
                        }
                        $value = implode($merge, $aValues);
                        $this->settingChange($levelKey, $itemKey, $value);
                    }
                } else {
                    unset($aConfigInfo['preg_split']);
                    unset($aConfigInfo['merge']);
                    foreach ($aConfigInfo as $levelKey => $itemKey) {
                        $this->settingChange($levelKey, $itemKey, $value);
                    }
                }
            } else {
                // The element may required "false" to be stored
                if (isset($aConfigInfo['bool'])) {
                    unset($aConfigInfo['bool']);
                    foreach ($aConfigInfo as $levelKey => $itemKey) {
                        $this->settingChange($levelKey, $itemKey, 'false');
                    }
                }
            }
        }
        $writeResult = $this->writeConfigChange();
        return $writeResult;
    }

}

?>