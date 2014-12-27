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

require_once MAX_PATH . '/lib/OA/Upgrade/UpgradePluginImport.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 */
class OX_Admin_UI_Install_InstallUtils
{
    public static $INSTALLER_SESSION_ID = 'ox_install_session_id';


    /**
     * Returns session storage associated with the installer.
     * This session storage is then used by wizard to store installer data
     * between the steps.
     *
     * @return OX_Admin_UI_SessionStorage session storage of installer
     */
    public static function getSessionStorage()
    {
        return new OX_Admin_UI_SessionStorage(self::$INSTALLER_SESSION_ID);
    }


    /**
     * Return an array of supported DB types
     *
     * @return array
     */
    public static function getSupportedDbTypes()
    {
        // These values must be the same as used for the
        // data access layer file names!
        $aTypes = array ();
        if (extension_loaded('mysql')) {
            $aTypes['mysql'] = 'MySQL';
        }
        if (extension_loaded('pgsql')) {
            $aTypes['pgsql'] = 'PostgreSQL';
        }

        return $aTypes;
    }


    /**
     * Return an array of supported Table types
     *
     * @return array
     */
    public static function getSupportedTableTypes()
    {
        // These values must be the same as used for the
        // data access layer file names!
        $aTypes = array ();
        if (extension_loaded('mysql')) {
            $aTypes['MYISAM'] = 'MyISAM';
            $aTypes['INNODB'] = 'InnoDB';
        }
        if (empty($aTypes)) {
            $aTypes[''] = 'Default';
        }
        return $aTypes;
    }


    /**
     * Checks a folder to make sure it exists and is writable
     *
     * @param  int Folder the directory that needs to be tested
     * @return boolean - true if folder exists and is writable
     */
    public static function checkFolderPermissions($folder)
    {
        if (!file_exists($folder)) {
            return false;
        }
        elseif (!is_writable($folder)) {
            return false;
        }
        return true;
    }


    /**
     * Checks if upgrader discovered schema which is old and stores stats
     * in server time rather than UTC.
     *
     * @param OA_Upgrade $oUpgrader
     */
    public static function hasZoneError($oUpgrader)
    {
        $tzoneErr = false;

        if ($oUpgrader->canUpgradeOrInstall()) {
            // Timezone support check
            if ($oUpgrader->existing_installation_status != OA_STATUS_NOT_INSTALLED) {
                if ($oUpgrader->versionInitialSchema['tables_core'] < 538) {
                    // Non TZ-enabled database
                    $tzoneErr = true;
                }
            }
        }

        return $tzoneErr;
    }


    /**
     * Checks if plugins path can be verified before upgrading. If path to previous
     * installation is not correct try to guess one.
     *
     * List of plugins is determined by looking into config section in the loaded
     * config file. (more precisely $GLOBALS['_MAX']['CONF']['plugins'])
     *
     * Return values is an two element array: ('verified' => boolean, 'path' => string).
     * If verified is true, 'path' will be empty.
     *
     * @return array an array of two elements ('verified' => boolean, 'path' => string).
     */
    public static function checkPluginsVerified()
    {
        $verified = true;
        $prevPath = '';
        if (!empty($GLOBALS['_MAX']['CONF']['plugins'])) {
            $oPluginImporter = new OX_UpgradePluginImport();
            if (!$oPluginImporter->verifyAll($GLOBALS['_MAX']['CONF']['plugins'])) {
                $verified = false;
                // See if we can figure out the previous path
                if (!empty($GLOBALS['_MAX']['CONF']['store']['webDir'])){
                    $possPath = dirname(dirname($GLOBALS['_MAX']['CONF']['store']['webDir']));
                    $oPluginVerifier = new OX_UpgradePluginImport();
                    $oPluginVerifier->basePath = $possPath;
                    $oPluginVerifier->destPath = $possPath;
                    if ($oPluginVerifier->verifyAll($GLOBALS['_MAX']['CONF']['plugins'], false)) {
                        $prevPath = $possPath;
                    }
                }
            }
        }

        return array('verified' => $verified, 'path' => $prevPath);
    }


    /**
     * Attempts import of plugins from previous installation path.
     * List of plugins is determined by looking into config section in the loaded
     * config file. (more precisely $GLOBALS['_MAX']['CONF']['plugins'])
     *
     * Copies plugin related artifacts using OX_UpgradePluginImport->import(..) function.
     * Also copies data objects.
     *
     * '$path' param is considered the source path. MAX path is
     * considered the target path.
     *
     * @param $path an absolute path to previous OpenX installation
     * @return boolean false if import failed, true otherwise
     */
    public static function importPlugins($path)
    {
        $success = true;

        // Prevent directory traversal and other nasty tricks:
        $path = str_replace("\\", '/', $path);
        $path = rtrim(str_replace("\0", '', $path), '/');
        if (!stristr($path, '../')) {
            $oPluginImporter = new OX_UpgradePluginImport();
            $oPluginImporter->basePath = $path;
            if ($oPluginImporter->verifyAll($GLOBALS['_MAX']['CONF']['plugins'], false)) {
                // For each plugin that's claimed to be installed... (ex|im)port it into the new codebase
                foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $plugin => $enabled) {
                    $oPluginImporter->import($plugin);
                }
                // Plugins may also have placed files in the MAX_PATH . /var/plugins folder,
                // but these files aren't declared in the XML, for now, copy all files in there up
                $DO_DIR = opendir($path . '/var/plugins/DataObjects/');
                while ($file = readdir($DO_DIR)) {
                    if (!is_file($path . '/var/plugins/DataObjects/' . $file)) {
                        continue;
                    }
                    @copy($path . '/var/plugins/DataObjects/' . $file, MAX_PATH . '/var/plugins/DataObjects/' . $file);
                }
            } else {
                $success = false;
            }
        }

        return $success;
    }


    /**
     * Processes upgrader messages and identfies their type (it's by prefix unfortunately...)
     * returns an array with errors under 'error' index, warnings under 'warning'
     * and other under 'info';
     *
     * @param unknown_type $aUpgraderMessages
     */
    public static function getMessagesWithType($aUpgraderMessages)
    {
        $aErrors = array();
        $aWarnings = array();
        $aInfos = array();

        $sErr  = '#! ';
        $sWarn = '#> ';
        foreach ($aUpgraderMessages AS $key => $message) {
            if (substr($message, 0 , 3) == $sErr) {
                $message = str_replace($sErr, '', $message);
                $aErrors[$key] = $message;
            }
            else if (substr($message, 0, 3) == $sWarn) {
                $message = str_replace($sWarn, '', $message);
                $aWarnings[$key] = $message;
            }
            else {
                $aInfos[$key] = $message;
            }
        }

        return array('error' => $aErrors, 'warning' => $aWarnings, 'info' => $aInfos);
    }
}

?>