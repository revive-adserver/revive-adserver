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

require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

class OA_Upgrade_Config
{

    var $oSettings;
    var $aConfig;
    var $configPath;
    var $configFile;

    function __construct()
    {
        $this->oSettings = new OA_Admin_Settings();
        // Use reference here
        $this->aConfig =& $this->oSettings->getConfigArray();
        // set default configPath
        $this->configPath = MAX_PATH.'/var/';
        if (!OA_Admin_Settings::isConfigWritable())
        {
            return false;
        }
    }

    function getRealConfigName()
    {
        if (file_exists($this->configPath.'default.conf.php'))
        {
            $conf = @parse_ini_file($this->configPath.'default.conf.php');
            if (isset($conf['realConfig']))
            {
                return $conf['realConfig'];
            }
            return false;
        }
    }

    function getConfigFileName()
    {
        if ($realConfig = $this->getRealConfigName())
        {
            $this->configFile = $realConfig.'.conf.php';
            return true;
        }
        $host = OX_getHostName();
        if (file_exists($host.'.conf.php'))
        {
            $this->configFile = $host.'.conf.php';
        }
        else if (file_exists($host.'.conf.ini'))
        {
            $this->configFile = $host.'.conf.ini';
        }
        else
        {
            $this->configFile = $host.'.conf.php';
        }
    }

    function isMaxConfigFile()
    {
        $host = OX_getHostName();
        $this->configPath = MAX_PATH.'/var/';
        if (file_exists($this->configPath.$host.'.conf.ini'))
        {
            return true;
        }
        return false;
    }

    function replaceMaxConfigFileWithOpenadsConfigFile()
    {
        $host = OX_getHostName();
        $this->configPath = MAX_PATH.'/var/';
        if (file_exists($this->configPath.$host.'.conf.ini'))
        {
            if ($this->oSettings->backupConfig($this->configPath.$host.'.conf.ini')) {
                if (copy($this->configPath.$host.'.conf.ini', $this->configPath.$host.'.conf.php'))
                {
                    unlink($this->configPath.$host.'.conf.ini');
                }
            }
        }
        return file_exists($this->configPath.$host.'.conf.php');
    }

    function putNewConfigFile()
    {
        $this->getInitialConfig();
        $this->getConfigFileName();
        if (!file_exists($this->configPath.$this->configFile))
        {
            copy(MAX_PATH.'/etc/dist.conf.php', $this->configPath.$this->configFile);
        }
        return true;
    }

    /**
     * at installation time we need to derive some values
     *
     */
    function getInitialConfig()
    {
        $this->setValue('store','webDir', MAX_PATH . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR .'images');
        $this->guessWebpath();
    }

    function guessWebpath()
    {
        $path = dirname($_SERVER['SCRIPT_NAME']);
        if (preg_match('#/www/admin$#', $path))
        {
            // User has web root configured as Openads' root directory so can guess at all locations
            $subpath = preg_replace('#/www/admin$#', '', $path);
            $basepath = OX_getHostNameWithPort() . $subpath. '/www/';
            $this->setValue('webpath', 'admin', $basepath.'admin');
            $this->setValue('webpath', 'delivery', $basepath.'delivery');
            $this->setValue('webpath', 'deliverySSL', $basepath.'delivery');
            $this->setValue('webpath', 'images', $basepath.'images');
            $this->setValue('webpath', 'imagesSSL', $basepath.'images');
        }
        else if (preg_match('#/admin$#', $path))
        {
            // User has web root configured as Openads' /www directory so can guess at all locations
            $subpath = preg_replace('#/admin$#', '', $path);
            $basepath = OX_getHostName() . $subpath. '';
            $this->setValue('webpath', 'admin', $basepath.'/admin');
            $this->setValue('webpath', 'delivery', $basepath.'/delivery');
            $this->setValue('webpath', 'deliverySSL', $basepath.'/delivery');
            $this->setValue('webpath', 'images', $basepath.'/images');
            $this->setValue('webpath', 'imagesSSL', $basepath.'/images');
        }
        else
        {
            // User has web root configured as Openads' www/admin directory so can only guess the admin location
            $this->setValue('webpath', 'admin'   , OX_getHostName());
            $this->setValue('webpath', 'delivery', OX_getHostName());
            $this->setValue('webpath', 'images', OX_getHostName());
            $this->setValue('webpath', 'deliverySSL', OX_getHostName());
            $this->setValue('webpath', 'imagesSSL', OX_getHostName());
        }
    }

    /**
     * Backs up the existing config file.
     *
     * @return boolean True if config is successfully backed up. Otherwise,
     *                 false.
     */
    function backupConfig()
    {
        $this->getConfigFileName();
        if (!$this->oSettings->backupConfig($this->configPath . $this->configFile)) {
            return false;
        }
        return true;
    }
    /**
     * Writes out the config file
     *
     * @param boolean $reparse should we reparse the config file after writing?
     * @return boolean true if config is successfully written.  Otherwise, false.
     */
    function writeConfig($reparse = true)
    {
        return $this->oSettings->writeConfigChange(null, null, $reparse);
    }

    /**
     * Merges any changes from dist.conf.php into the configuration.
     *
     * @return boolean True if config is successfully merged. Otherwise, false.
     */
    function mergeConfig()
    {
        $this->getConfigFileName();
        return $this->oSettings->mergeConfigChanges();
    }

    function getConfigBackupName()
    {
        return $this->oSettings->backupFilename;
    }

    function clearConfigBackupName()
    {
        $this->oSettings->backupFilename = '';
        return true;
    }

    function setOpenadsInstalledOn()
    {
        $this->setValue('openads','installed', '1');
        return $this->writeConfig();
    }

    function setMaxInstalledOff()
    {
        $this->setValue('max','installed', '0');
    }

    function setupConfigPan($aConfig)
    {
        foreach ($aConfig AS $section => &$aKey)
        {
            foreach ($aKey AS $name => &$value)
            {
                $this->setValue($section, $name, $value);
            }
        }
    }

    function setupConfigWebpath($aConfig)
    {
        foreach ($aConfig AS $k => $v)
        {
            $this->setValue('webpath', $k, preg_replace('#/$#', '', $v));
        }
    }

    function setupConfigStore($aConfig)
    {
        $this->setValue('store', 'mode', 0);
        $this->setValue('store', 'webDir', $aConfig['webDir']);
    }

    function setupConfigPriority($aConfig)
    {
        $this->setValue('priority', 'randmax', mt_getrandmax());
    }

    function setupConfigDatabase($aConfig)
    {
        $this->setValue('database', 'type',     $aConfig['type']);
        $this->setValue('database', 'host',     ($aConfig['host'] ? $aConfig['host'] : 'localhost'));
        $this->setValue('database', 'socket',   $aConfig['socket']);
        if (empty($aConfig['port']))
        {
            switch ($aConfig['type'])
            {
                case 'mysql':
                    $aConfig['port'] = '3306';
                    break;
                case 'pgsql':
                    $aConfig['port'] = '5432';
                    break;
            }
        }
        $this->setValue('database', 'port',     $aConfig['port']);
        $this->setValue('database', 'username', $aConfig['username']);
        $this->setValue('database', 'password', $aConfig['password']);
        $this->setValue('database', 'name',     $aConfig['name']);
        $this->setValue('database', 'persistent',     $aConfig['persistent']);
        $this->setValue('database', 'mysql4_compatibility', $aConfig['mysql4_compatibility']);
        $this->setValue('database', 'protocol', $aConfig['protocol']);
    }

    function setupConfigDatabaseCharset($aConfig)
    {
        $this->setValue('databaseCharset', 'checkComplete', $aConfig['checkComplete']);
        $this->setValue('databaseCharset', 'clientCharset', $aConfig['clientCharset']);
    }

    function setupConfigTable($aConfig)
    {
        $this->setValue('table', 'prefix', $aConfig['prefix']);
        $this->setValue('table', 'type', $aConfig['type']);
    }

    function setPluginsDisabled()
    {
        $this->setBulkValue('plugins', 0);
        $this->setBulkValue('pluginGroupComponents', 0);
    }

    function setValue($section, $name, $value)
    {
        $this->oSettings->settingChange($section, $name, $value);
    }

    function setBulkValue($section, $value)
    {
        $this->oSettings->bulkSettingChange($section, $value);
    }

    function getValue($section, $name, $value)
    {
        return $this->oSettings->conf[$section][$name];
    }

    function setGetValue($section, $name)
    {
        $this->setValue($section, $name, $this->getValue($section, $name));
    }

    function setGlobals()
    {
        foreach ($this->aConfig AS $sectionName => &$aSection)
        {
            foreach ($aSection as $k=>$v)
            {
                $GLOBALS['_MAX']['CONF'][$sectionName][$k] = $v;
            }
        }
    }

    /**
     * Check if there are items in the dist.conf.php file
     * which do not exist in the working conf array
     *
     * @param array optional $aConfigWork - An array of "dist" config items
     *                               or null to read the dist.conf.php file
     * @return boolean True for new config items
     */
    function checkForConfigAdditions($aConfDist = null)
    {
        if (is_null($aConfDist)) {
            $aConfDist = @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', true);
        }

        // If the $aConfDist array is empty, then either an empty array was passed in
        // or there was an error parsing the dist.conf.php file, return false so user's
        // config file remains unchanged
        if (empty($aConfDist)) {
            return false;
        }

        // Check for any new keys in dist
        foreach ($aConfDist as $key => &$value) {
        	if (array_key_exists($key, $this->aConfig)) {
        	    if (is_array($aConfDist[$key])) {
            	    foreach ($aConfDist[$key] as $subKey => &$subValue) {
            	    	if (!array_key_exists($subKey, $this->aConfig[$key])) {
                            return true;
            	    	}
            	    }
        	    }
        	} else {
                return true;
        	}
        }

        // If we get here, there are no keys in the dist that do not exist in the working conf
        return false;
    }
}


?>
