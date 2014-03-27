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

define('OA_STATUS_PLUGIN_NOT_INSTALLED',      -1);
define('OA_STATUS_PLUGIN_CURRENT_VERSION',     0);
define('OA_STATUS_PLUGIN_VERSION_FAILED',      3);
define('OA_STATUS_PLUGIN_DBINTEG_FAILED',      5);
//define('OA_STATUS_PLUGIN_CONFINTEG_FAILED',    6);
define('OA_STATUS_PLUGIN_CAN_UPGRADE',        10);

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

// setup oUpgrader, determine whether they are installing or that they can Upgrade

/**
 * @package OpenXPlugin
 */
class OX_Plugin_UpgradeComponentGroup extends OA_Upgrade
{

    var $oComponentGroupManager;
    var $aComponentGroup;

    function __construct($aComponentGroup, $oComponentGroupManager)
    {
        parent::__construct();

        $this->aComponentGroup          = $aComponentGroup;
        $this->oComponentGroupManager   = $oComponentGroupManager;

        $pluginPath = $this->oComponentGroupManager->getPathToComponentGroup($this->aComponentGroup['name']);
        $this->upgradePath      = $pluginPath.'etc/changes/';
        $this->oDBUpgrader->path_changes = $this->upgradePath;

        $this->recoveryFile     = MAX_PATH.'/var/plugins/recover/'.strtoupper($this->aComponentGroup['name']);
        /*$this->nobackupsFile    = MAX_PATH.$pluginPath.'NOBACKUPS';
        $this->postTaskFile     = MAX_PATH.$pluginPath.'TASKS.php';*/

        $this->initDatabaseConnection();
        if (!file_exists(MAX_PATH.'/var/plugins/log'))
        {
            @mkdir(MAX_PATH.'/var/plugins/log');
        }
        $this->oLogger->setLogFile('plugins/log/'.$this->aComponentGroup['name'].'_upgrade.log');
    }

    function canUpgrade()
    {
        $strDetected       = ' configuration file detected';
        $strCanUpgrade     = 'This version can be upgraded';
        $strNoUpgrade      = 'This version cannot be upgraded';
        $strProductName    = $this->aComponentGroup['name'];
        $this->oLogger->logClear();
        $this->oLogger->logOnly('Compiling details of currently installed '.$this->aComponentGroup['name']);
        $skipIntegrityCheck = true;
        if ( !empty($this->aComponentGroup['install']['schema']['mdb2schema']))
        {
            // if a schema is declared but no previous schema version found
            // its a new schema so don't bother with integrity check
            if (!$this->oComponentGroupManager->getSchemaInfo($this->aComponentGroup['install']['schema']['mdb2schema']))
            {
                $skipIntegrityCheck = false;
            }
        }
        $this->detectComponentGroup($skipIntegrityCheck);
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_PLUGIN_NOT_INSTALLED:
                $this->oLogger->log($strProductName.' not detected');
                $this->oLogger->logError($strNoUpgrade);
                return false;
                break;
            case OA_STATUS_PLUGIN_VERSION_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->logError($strNoUpgrade);
                return false;
                break;
            case OA_STATUS_PLUGIN_DBINTEG_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_PLUGIN_CAN_UPGRADE:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
            case OA_STATUS_CURRENT_VERSION:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log('This version is up to date.');
                return false;
        }
        return false;
    }

    function detectComponentGroup($skipIntegrityCheck = false)
    {
        $this->versionInitialApplication = $this->oVersioner->getApplicationVersion($this->aComponentGroup['name']);
        if (!$this->versionInitialApplication)
        {
            $this->existing_installation_status = OA_STATUS_PLUGIN_NOT_INSTALLED;
            return false;
        }
        $schemaName = $this->aComponentGroup['install']['schema']['mdb2schema'];
        $this->versionInitialSchema[$schemaName] = $this->oVersioner->getSchemaVersion($schemaName);

        $current = (version_compare($this->versionInitialApplication,$this->aComponentGroup['version'])==0);
        $valid   = (version_compare($this->versionInitialApplication,$this->aComponentGroup['version'])<0);
        if ($valid)
        {
            $this->aPackageList = $this->getUpgradePackageList($this->versionInitialApplication, $this->_readUpgradePackagesArray($this->upgradePath.$this->aComponentGroup['name'].'_upgrade_array.txt'));
            if (!$skipIntegrityCheck && count($this->aPackageList)>0)
            {
                $aSchema['name']    = $schemaName;
                $aSchema['schemaOld'] = MAX_PATH.$this->oComponentGroupManager->pathPackages.$this->aComponentGroup['name'].'/etc/changes/schema_tables_'.$this->aComponentGroup['name'].'_'.$this->versionInitialSchema[$schemaName].'.xml';
                if (!$this->_checkDBIntegrity($this->versionInitialSchema[$schemaName], $aSchema))
                {
                    $this->existing_installation_status = OA_STATUS_PLUGIN_DBINTEG_FAILED;
                    return false;
                }
            }
            $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
            $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
            $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
            return true;
        }
        else if ($current)
        {
            $this->existing_installation_status = OA_STATUS_CURRENT_VERSION;
            $this->aPackageList = array();
            return false;
        }
        $this->existing_installation_status = OA_STATUS_PLUGIN_VERSION_FAILED;
        return false;
    }

    function upgrade($input_file='', $timing='constructive')
    {
        // initialise database connection if necessary
        if (is_null($this->oDbh))
        {
            $this->initDatabaseConnection();
        }
        if (!$this->checkPermissionToCreateTable())
        {
            $this->oLogger->logError('Insufficient database permissions or incorrect database settings');
            return false;
        }
        // first deal with each of the packages in the list
        // that was compiled during detection
        if (count($this->aPackageList)>0)
        {
            foreach ($this->aPackageList AS $k => $this->package_file)
            {
                if (!$this->upgradeExecute($this->package_file))
                {
                    $halt = true;
                    break;
                }
            }
        }
        if ($halt)
        {
            return false;
        }
        $version = $this->aComponentGroup['version'];
        $this->package_file = $this->aComponentGroup['name'].'_version_stamp_'.$version;
        $this->oAuditor->setUpgradeActionId();
        $this->oAuditor->setKeyParams(array('upgrade_name'=>$this->package_file,
                                            'version_to'=>$version,
                                            'version_from'=>$this->versionInitialApplication,
                                            'logfile'=>basename($this->oLogger->logFile)
                                            )
                                     );
        $this->oAuditor->logAuditAction(array('description'=>'FAILED',
                                              'action'=>UPGRADE_ACTION_UPGRADE_FAILED,
                                             )
                                       );
        if (!$this->_upgradeConfig())
        {
            $this->oLogger->logError('Failed to upgrade configuration file');
            return false;
        }
        if (!$this->_putDataObjects())
        {
            $this->oLogger->logError('Failed to upgrade dataobjects');
            return false;
        }
        if ($this->versionInitialApplication != $version)
        {
            if (!$this->oVersioner->putApplicationVersion($version, $this->aComponentGroup['name']))
            {
                $this->oLogger->logError('Failed to update '.$this->aComponentGroup['name'].' version to '.$version);
                $this->message = 'Failed to update '.$this->aComponentGroup['name'].' version to '.$version;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
            $this->oLogger->log($this->aComponentGroup['name'].' version updated to '. $version);
        }
        $this->oAuditor->updateAuditAction(array('description'=>'UPGRADE COMPLETE',
                                                 'action'=>UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                 'confbackup'=>$this->oConfiguration->getConfigBackupName()
                                                )
                                          );
        $this->_pickupRecoveryFile();
        return true;
    }

    function _upgradeConfig()
    {
        return $this->_upgradeSettings() && $this->_upgradePreferences();
    }

    function _putDataObjects()
    {
        if ($this->aComponentGroup['install']['schema']['dboschema'])
        {
            $name = $this->aComponentGroup['name'];
            $aSchema = $this->aComponentGroup['install']['schema'];
            if (!$this->oComponentGroupManager->_putDataObjects($name, $aSchema))
            {
                $this->oLogger->logError('Failed to implement dataobjects for '.$name);
                //$this->_dropTables($name, $aSchema);
                return false;
            }
            if (!$this->oComponentGroupManager->_cacheDataObjects($name, $aSchema))
            {
                $this->oLogger->logError('Failed to cache dataobject schema for '.$name);
                //$this->_dropTables($name, $aSchema);
                return false;
            }
            if (!$this->oComponentGroupManager->_verifyDataObjects($name, $aSchema))
            {
                $this->oLogger->logError('Failed to verify dataobjects for '.$name);
                //$this->_dropTables($name, $aSchema);
                return false;
            }
        }
        return true;
    }

    function _upgradeSettings()
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->aComponentGroup['name']];
        foreach ($this->aComponentGroup['install']['conf']['settings'] AS $k => $aSet)
        {
            $aSettingsNew[] = array(
                                    'key'   => $aSet['key'],
                                    'value' => (array_key_exists($aSet['key'], $aConf) ? $aConf[$aSet['key']] : $aSet['value'])
                                   );
        }
        return $this->oComponentGroupManager->_unregisterSettings($this->aComponentGroup['name'],false)
            && $this->oComponentGroupManager->_registerSettings($this->aComponentGroup['name'], $aSettingsNew);
    }

    function _upgradePreferences()
    {
        $aPrefsNew = array();
        $aPrefsDel = array();
        foreach ($this->aComponentGroup['install']['conf']['preferences'] AS $k => $aPref)
        {
            $aPrefsNew[$aPref['name']] = $aPref;
        }
        $prefix = $this->aComponentGroup['name'].'_';
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->whereAdd('preference_name LIKE '.$this->oDbh->quote('%'.$prefix.'%'));
        $result = $doPreferences->find();
        while ($doPreferences->fetch())
        {
            if (array_key_exists(str_replace($prefix,'',$doPreferences->preference_name), $aPrefsNew))
            {
                // preference exists, ignore it ( what if the permission or default value has changed? )
                unset($aPrefsNew[str_replace($prefix,'',$doPreferences->preference_name)]);
            }
            else
            {
                // existing preference not found in new preference array, deprecated so delete
                $aPrefsDel[] = array('name'=>str_replace($prefix,'',$doPreferences->preference_name));
            }
        }
        foreach ($aPrefsNew AS $name => $aPref)
        {
            // insert
            $this->oComponentGroupManager->_registerPreferences($this->aComponentGroup['name'], $aPrefsNew);
        }
        foreach ($aPrefsDel AS $i => $aPrefs)
        {
            // delete
            $this->oComponentGroupManager->_unregisterPreferences($this->aComponentGroup['name'], $aPrefsDel);
        }
        return true;
    }

}



?>