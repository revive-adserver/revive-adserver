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
/**
 * Openads Upgrade Class
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

define('OA_STATUS_NOT_INSTALLED',          -1);
define('OA_STATUS_CURRENT_VERSION',         0);
define('OA_STATUS_PAN_NOT_INSTALLED',      -1);
define('OA_STATUS_PAN_CONFIG_DETECTED',     1);
define('OA_STATUS_PAN_DBCONNECT_FAILED',    2);
define('OA_STATUS_PAN_VERSION_FAILED',      3);
define('OA_STATUS_MAX_NOT_INSTALLED',      -1);
define('OA_STATUS_MAX_CONFIG_DETECTED',     1);
define('OA_STATUS_MAX_DBCONNECT_FAILED',    2);
define('OA_STATUS_MAX_VERSION_FAILED',      3);
define('OA_STATUS_OAD_NOT_INSTALLED',      -1);
define('OA_STATUS_OAD_CONFIG_DETECTED',     1);
define('OA_STATUS_OAD_DBCONNECT_FAILED',    2);
define('OA_STATUS_OAD_VERSION_FAILED',      3);
define('OA_STATUS_CAN_UPGRADE',            10);


require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

require_once MAX_PATH.'/lib/OA/DB.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/VersionController.php');
require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';
require_once MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/Configuration.php');

class OA_Upgrade
{
    var $upgradePath = '';

    var $message = '';

    var $oLogger;
    var $oParser;
    var $oDBUpgrader;
    var $oVersioner;
    var $oDBAuditor;
    var $oSystemMgr;
    var $oDbh;
    var $oPAN;
    var $oConfiguration;

    var $aPackage    = array();
    var $aDBPackages = array();
    var $aDsn = array();

    var $versionInitialApplication;
    var $versionInitialSchema = array();

    var $package_file = '';
    var $recoveryFile;

    var $remove_max_version = false;
    var $can_drop_database = false;

    var $existing_installation_status = -1;

    function OA_Upgrade()
    {
        $this->upgradePath  = MAX_PATH.'/etc/changes/';
        $this->recoveryFile = MAX_PATH.'/var/recover.log';

        $this->oLogger      = new OA_UpgradeLogger();
        $this->oParser      = new OA_UpgradePackageParser();
        $this->oDBUpgrader  = new OA_DB_Upgrade($this->oLogger);
        $this->oDBAuditor   = new OA_DB_UpgradeAuditor();
        $this->oVersioner   = new OA_Version_Controller();
        $this->oPAN         = new OA_phpAdsNew();
        $this->oSystemMgr   = new OA_Environment_Manager();
        $this->oConfiguration = new OA_Upgrade_Config();
        $this->oTable       = new OA_DB_Table();

        $this->oDBUpgrader->path_changes = $this->upgradePath;

        $this->aDsn['database'] = array();
        $this->aDsn['table']    = array();
        $this->aDsn['database']['type']     = 'mysql';
        $this->aDsn['database']['host']     = 'localhost';
        $this->aDsn['database']['port']     = '3306';
        $this->aDsn['database']['username'] = '';
        $this->aDsn['database']['passowrd'] = '';
        $this->aDsn['database']['name']     = '';
        $this->aDsn['table']['type']        = 'InnoDB';
        $this->aDsn['table']['prefix']      = 'oa_';
    }

    /**
     * initialise a database connection
     * hook up the various components with a db object
     *
     * @param array $dsn
     * @return boolean
     */
    function initDatabaseConnection($dsn=null)
    {
        if (is_null($this->oDbh))
        {
            //$this->oDbh = OA_DB::singleton($dsn);
            $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        }
        if (PEAR::isError($this->oDbh))
        {
            $this->oLogger->log($this->oDbh->getMessage());
            $this->oDbh = null;
            return false;
        }
        if (!$this->oDbh)
        {
            $this->oLogger->log('Unable to connect to database');
            $this->oDbh = null;
            return false;
        }

        $this->oTable->oDbh = $this->oDbh;
        $this->oDBUpgrader->initMDB2Schema();
        $this->oVersioner->init($this->oDbh);
        $this->oDBAuditor->init($this->oDbh, $this->oLogger);
        $this->oDBUpgrader->oAuditor = &$this->oDBAuditor;
        return true;
    }

    /**
     * add any needed database parameter to the config array
     *
     * @param array $aConfig
     *
     * @return array
     */
    function initDatabaseParameters($aConfig)
    {
        // Check if we need to ensure to enable MySQL 4 compatibility
        if (strcasecmp($aConfig['database']['type'], 'mysql') === 0) {
            $result = $this->oDbh->exec("SET SESSION sql_mode='MYSQL40'");
            $aConfig['database']['mysql4_compatibility'] = !PEAR::isError($result);
        }

        return $aConfig;
    }

    /**
     * see the recovery file and ye may findeth
     *
     * @return boolean
     */
    function isRecoveryRequired()
    {
        return $this->seekRecoveryFile();
    }

    /**
     * execute the db_upgrade recovery method
     *
     * @return unknown
     */
    function recoverUpgrade()
    {
        $this->aDBPackages = $this->seekRecoveryFile();
        $this->detectPAN();
        $this->detectMAX();
        if (!$this->initDatabaseConnection())
        {
            return false;
        }
        if (!$this->rollbackSchemas())
        {
            return false;
        }
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * return an array of system environment info
     *
     * @return array
     */
    function checkEnvironment()
    {
        return $this->oSystemMgr->checkSystem();
    }

    /**
     * look for existing installations (phpAdsNew, MMM, Openads)
     * retrieve details and check for errors
     *
     * @return boolean
     */
    function canUpgrade()
    {
        $strDetected    = ' configuration file detected';
        $strCanUpgrade  = 'This version can be upgraded';
        $strNoConnect   = 'Could not connect to the database';
        $strConnected   = 'Connected to the database ok';
        $strNoUpgrade   = 'This version cannot be upgraded';

        $this->oLogger->logClear();
        $this->detectPAN();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_PAN_NOT_INSTALLED:
                break;
            case OA_STATUS_PAN_CONFIG_DETECTED:
                $this->oLogger->logError('phpAdsNew'.$strDetected);
                break;
            case OA_STATUS_PAN_DBCONNECT_FAILED:
                $this->oLogger->logError('phpAdsNew'.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_PAN_VERSION_FAILED:
                $this->oLogger->log('phpAdsNew '.$this->versionInitialApplication.' detected');
                $this->oLogger->log($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log('phpAdsNew '.$this->versionInitialApplication.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->detectMAX();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_MAX_NOT_INSTALLED:
                break;
            case OA_STATUS_MAX_CONFIG_DETECTED:
                $this->oLogger->logError('Max Media Manager'.$strDetected);
                break;
            case OA_STATUS_MAX_DBCONNECT_FAILED:
                $this->oLogger->logError('Max Media Manager'.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_MAX_VERSION_FAILED:
                $database = $GLOBALS['_MAX']['CONF']['database']['name'];
                $this->oLogger->logError('Max Media Manager '.$this->versionInitialApplication.' detected');
                $this->oLogger->logError($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                break;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log('Max Media Manager '.$this->versionInitialApplication.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->detectOpenads();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_OAD_NOT_INSTALLED:
                $this->oLogger->log('Openads installation not detected');
                return true;
            case OA_STATUS_OAD_CONFIG_DETECTED:
                $this->oLogger->logError('Openads'.$strDetected);
                break;
            case OA_STATUS_OAD_DBCONNECT_FAILED:
                $this->oLogger->logError('Openads'.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                return false;
            case OA_STATUS_OAD_VERSION_FAILED:
                $database = $GLOBALS['_MAX']['CONF']['database']['name'];
                $this->oLogger->logError('Openads '.$this->versionInitialApplication.' detected');
                $this->oLogger->logError($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_CURRENT_VERSION:
                $this->oLogger->log('Openads '.$this->versionInitialApplication.' detected');
                $this->oLogger->log('This version is up to date.');
                return false;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log('Openads '.$this->versionInitialApplication.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }
        $this->oLogger->logError('Unknown Openads installation status');
        return false;
    }

    /**
     * check existance of upgrade package file
     *
     * @return boolean
     */
    function checkUpgradePackage()
    {
        if ($this->package_file)
        {
            if (!file_exists($this->upgradePath.$this->package_file))
            {
                $this->oLogger->logError('Upgrade package file '.$this->package_file.' NOT found');
                return false;
            }
            return true;
        }
        else if ($this->existing_installation_status == OA_STATUS_NOT_INSTALLED)
        {
            return true;
        }
        $this->oLogger->logError('No upgrade package file specified');
        return false;
    }

    /**
     * search for an existing phpAdsNew installation
     *
     * @param string $database (used for error display message)
     * @return boolean
     */
    function detectPAN()
    {
        $this->oPAN->init();
        if ($this->oPAN->detected)
        {
            $GLOBALS['_MAX']['CONF']['database'] = $this->oPAN->aDsn['database'];
            $GLOBALS['_MAX']['CONF']['table']    = $this->oPAN->aDsn['table'];
            $this->existing_installation_status = OA_STATUS_PAN_CONFIG_DETECTED;
            if (PEAR::isError($this->oPAN->oDbh))
            {
                $this->existing_installation_status = OA_STATUS_PAN_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oPAN->getPANversion();
            if ($this->versionInitialApplication) // its PAN
            {
                $valid = (version_compare($this->versionInitialApplication,'200.500')>=0);
                if ($valid)
                {
                    $this->versionInitialSchema['tables_core'] = '100';
                    $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                    $this->package_file = 'openads_upgrade_2.0.12_to_2.3.32_beta.xml';
                    $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                    $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                    return true;
                }
                $this->existing_installation_status = OA_STATUS_PAN_VERSION_FAILED;
                return false;
            }
        }
        $this->existing_installation_status = OA_STATUS_PAN_NOT_INSTALLED;
        return false;
    }

    /**
     * search for an existing Max Media Manager installation
     *
     * @param string $database (used for error display message)
     * @return boolean
     */
    function detectMAX()
    {
        if ($GLOBALS['_MAX']['CONF']['max']['installed'])
        {
            $this->existing_installation_status = OA_STATUS_MAX_CONFIG_DETECTED;
            if (!$this->initDatabaseConnection())
            {
                $this->existing_installation_status = OA_STATUS_MAX_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion('max');
            if ($this->versionInitialApplication) // its MAX
            {
                $valid = (version_compare($this->versionInitialApplication,'v0.3.31-alpha')>=0);
                if ($valid)
                {
                    $this->versionInitialSchema['tables_core'] = '500';
                    $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                    $this->remove_max_version = true;
                    $this->package_file     = 'openads_upgrade_2.3.31_to_2.3.32_beta.xml';
                    $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                    $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                    return true;
                }
                $this->existing_installation_status = OA_STATUS_MAX_VERSION_FAILED;
                return false;
            }
        }
        $this->existing_installation_status = OA_STATUS_MAX_NOT_INSTALLED;
        return false;
    }

    /**
     * search for an existing Openads installation
     *
     * @param string $database (used for error display message)
     * @return boolean
     */
    function detectOpenads()
    {
        if ($GLOBALS['_MAX']['CONF']['max']['installed'])
        {
            $this->existing_installation_status = OA_STATUS_CONFIG_FOUND;
            if (!$this->initDatabaseConnection())
            {
                $this->existing_installation_status = OA_STATUS_MAX_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
            if ($this->versionInitialApplication) // its openads
            {
                $current = (version_compare($this->versionInitialApplication,OA_VERSION)==0);
                $valid   = (version_compare($this->versionInitialApplication,OA_VERSION)<0);
                if ($valid)
                {
//                    there are no openads upgrade packages yet
//                    the first will probably be openads_upgrade_2.3.32_to_2.3.33_beta
//                    by the time the first package is ready
//                    we will be looking at working out incremental upgrades
                    $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                    $this->package_file     = 'openads_upgrade_2.3.32_to_2.3.33_beta.xml';
                    $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                    $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                    return true;
                }
                else if ($current)
                {
                    $this->existing_installation_status = OA_STATUS_CURRENT_VERSION;
                    $this->package_file = '';
                    return true;
                }
                $this->existing_installation_status = OA_STATUS_OAD_VERSION_FAILED;
                return false;
            }
        }
        $this->existing_installation_status = OA_STATUS_OAD_NOT_INSTALLED;
        return false;
    }

    /**
     * execute the installation steps
     *
     * @return boolean
     */
    function install($aConfig)
    {
        $this->oLogger->setLogFile('install.log');
        $this->oLogger->deleteLogFile();
        $this->aDsn['database'] = $aConfig['database'];
        $this->aDsn['table']    = $aConfig['table'];

        $this->oLogger->log('Installation started '.OA::getNow());
        $this->oLogger->log('Attempting to connect to database '.$this->aDsn['database']['name'].' with user '.$this->aDsn['database']['username']);

        if (!$this->_createDatabase())
        {
            $this->oLogger->logError('Installation failed to create the database '.$this->aDsn['database']['name']);
            return false;
        }
        $this->oLogger->log('Connected to database '.$this->oDbh->connected_database_name);

        if (!$this->checkPermissionToCreateTable())
        {
            $this->oLogger->logError('Insufficient database permissions to install');
            return false;
        }

        if (!$this->initDatabaseConnection())
        {
            $this->oLogger->logError('Installation failed to connect to the database '.$this->aDsn['database']['name']);
            $this->_dropDatabase();
            return false;
        }

        $aConfig = $this->initDatabaseParameters($aConfig);

        if (!$this->createCoreTables())
        {
            $this->oLogger->logError('Installation failed to create the core tables');
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation created the core tables');

        if (!$this->oVersioner->putSchemaVersion('tables_core', $this->oTable->aDefinition['version']))
        {
            $this->oLogger->logError('Installation failed to update the schema version to '.$oTable->aDefinition['version']);
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation updated the schema version to '.$this->oTable->aDefinition['version']);

        if (!$this->oVersioner->putApplicationVersion(OA_VERSION))
        {
            $this->oLogger->logError('Installation failed to update the application version to '.OA_VERSION);
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation updated the application version to '.OA_VERSION);

        $this->oConfiguration->getInitialConfig();
        if (!$this->saveConfigDB($aConfig))
        {
            $this->oLogger->logError('Installation failed to write database details to the configuration file '.$this->oConfiguration->configFile);
            if (file_exists($this->oConfiguration->configPath.$this->oConfiguration->configFile))
            {
                unlink($this->oConfiguration->configPath.$this->oConfiguration->configFile);
                $this->oLogger->log('Installation deleted the configuration file '.$this->oConfiguration->configFile);
            }
            $this->_dropDatabase();
            return false;
        }
        return true;
    }

    /**
     * remove the currently connected database
     *
     * @param boolean $log
     */
    function _dropDatabase($log = true)
    {
        if ($this->can_drop_database)
        {
            if (OA_DB::dropDatabase($this->aDsn['database']['name']))
            {
                if ($log)
                {
                    $this->oLogger->log('Installation dropped the database '.$this->aDsn['database']['name']);
                }
                return true;
            }
            $this->oLogger->logError('Installation failed to drop the database '.$this->aDsn['database']['name']);
            return false;
        }
        else
        {
            $this->oTable->dropAllTables();
            if ($log)
            {
                $this->oLogger->log('Installation dropped the core tables from database '.$this->aDsn['database']['name']);
            }
            return true;
        }
    }

    /**
     * create the empty database
     *
     * @return boolean
     */
    function _createDatabase()
    {
        $this->oDbh = &OA_DB::singleton(OA_DB::getDsn($this->aDsn));
        $GLOBALS['_MAX']['CONF']['database']          = $this->aDsn['database'];
        $GLOBALS['_MAX']['CONF']['table']['prefix']   = $this->aDsn['table']['prefix'];
        $GLOBALS['_MAX']['CONF']['table']['type']     = $this->aDsn['table']['type'];
        if (PEAR::isError($this->oDbh))
        {
            if ($this->oDbh->getCode()==MDB2_ERROR_CONNECT_FAILED)
            {
                $this->oLogger->logError($this->oDbh->getMessage());
                return false;
            }

            $GLOBALS['_OA']['CONNECTIONS']  = array();
            $GLOBALS['_MDB2_databases']     = array();

            $result = OA_DB::createDatabase($this->aDsn['database']['name']);
            if (PEAR::isError($result))
            {
                $this->oLogger->logError($result->getMessage());
                return false;
            }
            $this->oDbh = OA_DB::changeDatabase($this->aDsn['database']['name']);
            if (PEAR::isError($this->oDbh))
            {
                $this->oLogger->logError($this->oDbh->getMessage());
                $this->oDbh = null;
                return false;
            }
            $this->oLogger->log('Database created '.$this->aDsn['database']['name']);
            $this->can_drop_database = true;
        }
        return true;
    }

    /**
     * create the tables_core schema in the database
     *
     * @return boolean
     */
    function createCoreTables()
    {
        if ($this->oTable->init(MAX_PATH.'/etc/tables_core.xml'))
        {
            $this->oTable->dropAllTables();
            return $this->oTable->createAllTables();
        }
        return false;
    }

    function setOpenadsInstalledOn()
    {
        $this->oConfiguration->setOpenadsInstalledOn();
    }

    /**
     * retrieve the configuration settings
     *
     * @return array
     */
    function getConfig()
    {
        if (!$GLOBALS['_MAX']['CONF']['max']['installed'])
        {
            $this->oConfiguration->getInitialConfig();
        }
        return $this->oConfiguration->aConfig;
    }

    /**
     * save database configuration settings
     *
     * @param array $aConfig
     * @return boolean
     */
    function saveConfigDB($aConfig)
    {
        $this->oConfiguration->setupConfigDatabase($aConfig['database']);
        $this->oConfiguration->setupConfigTable($aConfig['table']);
        return $this->oConfiguration->writeConfig();
    }

    /**
     * save configuration settings
     *
     * @param array $aConfig
     * @return boolean
     */
    function saveConfig($aConfig)
    {
        $this->oConfiguration->setupConfigWebPath($aConfig['webpath']);
        $this->oConfiguration->writeConfig();
        $aConfig['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
        $this->oConfiguration->setupConfigDatabase($aConfig['database']);
        $this->oConfiguration->setupConfigTable($aConfig['table']);
        $this->oConfiguration->setupConfigTimezone($aConfig['timezone']);
        $this->oConfiguration->setupConfigStore($aConfig['store']);
        $this->oConfiguration->setupConfigMax($aConfig['max']);
        $this->oConfiguration->setupConfigPriority('');
        return $this->oConfiguration->writeConfig();
    }

    /**
     * execute the upgrade steps
     *
     * @return boolean
     */
    function upgrade($input_file, $timing='constructive')
    {
        $this->oLogger->setLogFile($this->_getUpgradeLogFileName($input_file, $timing));
        $this->oDBUpgrader->logFile = $this->oLogger->logFile;

        if (!$this->_parseUpgradePackageFile($this->upgradePath.$input_file))
        {
            return false;
        }

        if (is_null($this->oDbh))
        {
            $this->initDatabaseConnection();
        }
        if (!$this->checkPermissionToCreateTable())
        {
            $this->oLogger->logError('Insufficient database permissions');
            return false;
        }
        if (!$this->upgradeSchemas())
        {
            return false;
        }
        if (!$this->oVersioner->putApplicationVersion(OA_VERSION))
        {
            $this->oLogger->log('Failed to update application version to '.OA_VERSION);
            $this->message = 'Failed to update application version to '.OA_VERSION;
            return false;
         }
        $this->oLogger->log('Application version updated to '. OA_VERSION);

        // clean up old version artefacts
        if ($this->remove_max_version)
        {
            if ($this->oConfiguration->isMaxConfigFile())
            {
                if (!$this->oConfiguration->replaceMaxConfigFileWithOpenadsConfigFile())
                {
                    $this->oLogger->logError('Failed to replace MAX configuration file with Openads configuration file');
                    $this->message = 'Failed to replace MAX configuration file with Openads configuration file';
                    return false;
                }
                $this->oLogger->logError('Replaced MAX configuration file with Openads configuration file');
                $this->oConfiguration->setMaxInstalledOff();
                $this->oConfiguration->writeConfig();
            }
            if (!$this->oVersioner->removeMaxVersion())
            {
                $this->oLogger->logError('Failed to remove MAX application version');
                $this->message = 'Failed to remove MAX application version';
                return false;
            }
            $this->oLogger->log('Removed MAX application version');
            $this->oConfiguration->setupConfigPriority('');
            if (!$this->oConfiguration->writeConfig())
            {
                $this->oLogger->logError('Failed to set the randmax priority value');
                $this->message = 'Failed to set the randmax priority value';
                return false;
            }
        }
        if ($this->oPAN->detected)
        {
            if (!$this->oConfiguration->putNewConfigFile())
            {
                $this->oLogger->logError('Installation failed to create the configuration file');
                return false;
            }
            $aConfig = $this->oPAN->aConfig;
            $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
            $this->oConfiguration->setupConfigPan($aConfig);
            $this->oConfiguration->writeConfig();
            if (!$this->oPAN->renamePANConfigFile())
            {
                $this->oLogger->logError('Failed to rename PAN configuration file (non-critical, you can delete or rename /var/config.inc.php yourself)');
                $this->message = 'Failed to rename PAN configuration file (non-critical, you can delete or rename /var/config.inc.php yourself)';
                return true;
            }
        }
        $aConfig['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $aConfig = $this->initDatabaseParameters($aConfig);
        $this->saveConfigDB($aConfig);
        return true;
    }

/*
    function getAdmin()
    {
        require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
        $oPrefs = new MAX_Admin_Preferences();
        $aAdmin = $oPrefs->loadPrefs();
        if (empty($aAdmin))
        {
            if ($this->putAdmin())
            {
                $aAdmin = $oPrefs->loadPrefs();
            }
        }
        return $aAdmin;
    }
*/

    /**
     * insert admin record into preferences table
     *
     * @param array $aAdmin
     * @return boolean
     */
    function putAdmin($aAdmin)
    {
        require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
        // Insert basic preferences into database
        $oPrefs = new MAX_Admin_Preferences();

        // Load preferences, needed below to check instance_id existance
        $oPrefs->loadPrefs();

        $oPrefs->setPrefChange('config_version', OA_VERSION);
        $oPrefs->setPrefChange('admin', $aAdmin['name']);
        $oPrefs->setPrefChange('admin_email', $aAdmin['email']);
        $oPrefs->setPrefChange('admin_pw', md5($aAdmin['pword']));

        // Generate a new instance ID if empty
        if (empty($GLOBALS['_MAX']['PREF']['instance_id'])) {
            $oPrefs->setPrefChange('instance_id',  sha1(uniqid('', true)));
        }

        if (!$oPrefs->writePrefChange())
        {
            $this->oLogger->log('error writing admin preference record');
            return false;
        }
        return true;
    }

    /**
     * calls the dummy data class insert() method
     * which uses the DataGenerator to insert some data
     *
     * @return boolean
     */
    function insertDummyData()
    {
        require_once MAX_PATH.'/lib/OA/Upgrade/DummyData.php';
        $oDummy = new OA_Dummy_Data();
        $oDummy->insert();
        return true;
    }


    /**
     * this can be used to run custom scripts
     * for planned enhancement: pre/post upgrade
     *
     * @param string $file
     * @param string $classprefix
     * @return boolean
     */
    function runScript($file, $classprefix)
    {
        $class = str_replace('.php', '', basename($file));
        if (!$file)
        {
            return true;
        }
        else if (file_exists($file))
        {
            $this->oLogger->log('acquiring script '.$file);
            require_once $file;
            if (class_exists($class))
            {
                $this->oLogger->log('instantiating class '.$class);
                $oScript = new $class;
                $method = 'execute';
                if (is_callable(array($oScript, $method)))
                {
                    $this->oLogger->log('method is callable '.$method);
                    if (!call_user_func(array($oScript, $method), ''))
                    {
                        $this->oLogger->logError('script returned false '.$class);
                        return false;
                    }
                    return true;
                }
                $this->oLogger->logError('method not found '.$method);
                return false;
            }
            $this->oLogger->logError('class not found '.$class);
            return false;
        }
        $this->oLogger->logError('script not found '.$file);
        return false;
    }

    /**
     * test if the database username has permissions to create tables
     *
     * @return boolean
     */
    function checkPermissionToCreateTable()
    {
        $tblTmp = 'oa_tmp_dbpriviligecheck';
        $aExistingTables = $this->oDbh->manager->listTables();
        if (in_array($tblTmp, $aExistingTables))
        {
            $result = $this->oDbh->exec('DROP TABLE '.$tblTmp);
        }
        $result = $this->oDbh->exec("CREATE TABLE {$tblTmp} (tmp int)");
        $data   = $this->oDbh->manager->listTableFields($tblTmp);
        PEAR::popErrorHandling();
        if (!PEAR::isError($data))
        {
            $result = $this->oDbh->exec('DROP TABLE '.$tblTmp);
            $this->oLogger->log('Database permissions are OK');
            return true;
        } else
        {
            $this->oLogger->logError('Failed to create test privileges table - check your database permissions');
            return false;
        }
    }

    /**
     * execute each of the db upgrade packages
     *
     * @return boolean
     */
    function upgradeSchemas()
    {
        foreach ($this->aDBPackages as $k=>$aPkg)
        {
            if (!array_key_exists($aPkg['schema'],$this->versionInitialSchema))
            {
                $this->versionInitialSchema[$aPkg['schema']] = $this->oVersioner->getSchemaVersion($aPkg['schema']);
            }
            $ok = false;
            $this->_writeRecoveryFile($aPkg['schema'], $aPkg['version']);
            if ($this->oDBUpgrader->init('constructive', $aPkg['schema'], $aPkg['version']))
            {
                if ($this->_runUpgradeSchemaPreScript($aPkg['prescript']))
                {
                    if ($this->oDBUpgrader->upgrade())
                    {
                        if ($this->_runUpgradeSchemaPostscript($aPkg['postscript']))
                        {
                            $ok = true;
                        }
                    }
                }
            }
            // for now we execute destructive immediately after constructive
            if ($ok)
            {
                $ok = false; // start over - should return true throughout even if nothing to do
                // last param 'true' will reset the object without having to re-parse the schema
                if ($this->oDBUpgrader->init('destructive', $aPkg['schema'], $aPkg['version'], true))
                {
                    if ($this->_runUpgradeSchemaPreScript($aPkg['prescript']))
                    {
                        if ($this->oDBUpgrader->upgrade())
                        {
                            if ($this->_runUpgradeSchemaPostscript($aPkg['postscript']))
                            {
                                $ok = true;
                            }
                        }
                    }
                }
            }
            if ($ok)
            {
              $version = ( $aPkg['stamp'] ?  $aPkg['stamp'] : $aPkg['version']);
              $this->oVersioner->putSchemaVersion($aPkg['schema'],$version);
            }
            else
            {
                if ($this->rollbackSchemas())
                {
                    $this->_pickupRecoveryFile();
                }
                return false;
            }
        }
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * call the db_upgrader's prepare and run script functions
     * for pre / post upgrade schema packages
     *
     * @param string $file
     * @return boolean
     */
    function _runUpgradeSchemaPreScript($file)
    {
        if ($file)
        {
            if (!$this->oDBUpgrader->prepPreScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping prescript: '.$this->upgradePath.$file);
                return false;
            }
            if(!$this->oDBUpgrader->runPreScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping prescript: '.$this->upgradePath.$file);
                return false;
            }
        }
        return true;
    }

    /**
     * call the db_upgrader's prepare and run script functions
     * for pre / post upgrade schema packages
     *
     * @param string $file
     * @return boolean
     */
    function _runUpgradeSchemaPostScript($file)
    {
        if ($file)
        {
            if (!$this->oDBUpgrader->prepPostScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping postscript: '.$this->upgradePath.$file);
                return false;
            }
            if(!$this->oDBUpgrader->runPostScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping postscript: '.$this->upgradePath.$file);
                return false;
            }
        }
        return true;
    }

    /**
     * for each schema, replace the upgraded tables with the backup tables
     *
     * @return boolean
     */
    function rollbackSchemas()
    {
        foreach ($this->versionInitialSchema AS $schema => $version)
        {
            if ($this->oVersioner->getSchemaVersion($schema) != $version)
            {
                krsort($this->aDBPackages);
                foreach ($this->aDBPackages as $k=>$aPkg)
                {
                    if (!$this->oDBUpgrader->init('destructive', $aPkg['schema'], $aPkg['version']))
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->prepRollback())
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->rollback())
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->init('constructive', $aPkg['schema'], $aPkg['version']))
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->prepRollback())
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->rollback())
                    {
                        return false;
                    }
                    $this->oVersioner->putSchemaVersion($aPkg['schema'], $aPkg['version']);
                }
                $this->oVersioner->putSchemaVersion($schema, $version);
            }
        }
        return true;
    }


    /**
     * use the xml parser to parse the upgrade package
     *
     * @param string $input_file
     * @return array
     */
    function _parseUpgradePackageFile($input_file)
    {
        $result = $this->oParser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $this->oParser->parse();
        if (PEAR::isError($result))
        {
            $this->oLogger->logError('problem parsing the package file: '.$result->getMessage());
            return false;
        }
        if (PEAR::isError($this->oParser->error))
        {
            $this->oLogger->logError('problem parsing the package file: '.$this->oParser->error);
            return false;
        }
        $this->aPackage     = $this->oParser->aPackage;
        $this->aDBPackages  = $this->aPackage['db_pkgs'];

        return true;
    }

    /**
     * not used in actual upgrader
     * retrieve a list of available upgrade packages
     *
     * @return array
     */
    function _getPackageList()
    {
        $aFiles = array();
        $dh = opendir($this->upgradePath);
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match('/openads_upgrade_[\w\W\d]+_to_([\w\W\d])+\.xml/', $file, $aMatches))
                {
                    $aFiles[] = $file;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }

    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _compileChangesetInfo()
    {
        $this->aChangesetList = $this->_getChangesetList();
        foreach ($this->aChangesetList as $version=>$aFiles)
        {
            $file       = MAX_PATH.'/etc/changes/'.$aFiles['changeset'];
            $aChanges   = $this->oDBUpgrader->oSchema->parseChangesetDefinitionFile($file);
            if (!$this->_isPearError($aChanges, "failed to parse changeset ({$file})"))
            {
                $this->_log('changeset found in file: '.$file);
                $this->_log('name: '.$aChanges['name']);
                $this->_log('version: '.$aChanges['version']);
                $this->_log('comments: '.$aChanges['comments']);
                $this->_log(($aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
                $this->_log(($aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
            }
            else
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _checkChangesetAudit($schema)
    {
        $aResult = $this->oDBAuditor->queryAudit(null, null, $schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
        if ($aResult)
        {
            foreach ($aResult as $k=>$v)
            {
                $this->oLogger->log($v['schema_name'].' upgraded to version '.$v['version'].' on '.$v['updated']);
            }
        }
        return true;
    }

    /**
     * retrieve the message errary
     *
     * @return boolean
     */
    function getMessages()
    {
        return $this->oLogger->aMessages;
    }

    /**
     * not used anymore i think
     * retrieve the error array
     *
     * @return boolean
     */
    function getErrors()
    {
        return $this->oLogger->aErrors;
    }

    /**
     * write the version, schema and timestamp to a small temp file in the var folder
     * this will be written when an upgrade starts and deleted when it ends
     * if this file is present outside of the upgrade process it indicates that
     * the upgrade was interrupted
     *
     * @return boolean
     */
    function _writeRecoveryFile($schema, $version)
    {
        $log = fopen($this->recoveryFile, 'a');
        $date = date('Y-m-d h:i:s');
        fwrite($log, "{$schema}/{$version}/{$date}/{$this->versionInitialSchema[$schema]}/{$this->versionInitialApplication};\r\n");
        fclose($log);
        return file_exists($this->recoveryFile);
    }

    function _pickupRecoveryFile()
    {
        if (file_exists($this->recoveryFile))
        {
            unlink($this->recoveryFile);
        }
        return (!file_exists($this->recoveryFile));
    }

    function seekRecoveryFile()
    {
        if (file_exists($this->recoveryFile))
        {
            $aContent = explode(';', file_get_contents($this->recoveryFile));
            foreach ($aContent as $k => $v)
            {
                if (trim($v))
                {
                    $aLine = explode('/', trim($v));
                    $aResult[] = array(
                                        'schema'    =>$aLine[0],
                                        'version'   =>$aLine[1],
                                        'updated'   =>$aLine[2],
                                        'versionInitialSchema'      =>$aLine[3],
                                        'versionInitialApplication' =>$aLine[4],
                                        );
                }
            }
            return $aResult;
        }
        return false;
    }

    function _getUpgradeLogFileName($input_file, $timing)
    {
        return str_replace('.xml', '', $input_file).'_'.$timing.'_'.OA::getNow('Y_m_d_h_i_s').'.log';
    }


    /**
     * compile a list of changesets available in /etc/changes
     * could be used for a changeset manager
     *
     *
     * @return array
     */
    /*
    function _getChangesetList($schema)
    {
        $aFiles = array();
        $dh = opendir(MAX_PATH.'/etc/changes');
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match("/schema_{$schema}_([\d])+\.xml/", $file, $aMatches))
                {
                    $version = $aMatches[1];
                    $fileSchema = basename($file);
                    $aFiles[$version] = array();
                    $fileChanges = str_replace('schema', 'changes', $fileSchema);
                    $fileMigrate = str_replace('schema', 'migration', $fileSchema);
                    $fileMigrate = str_replace('xml', 'php', $fileMigrate);
                    if (!file_exists(MAX_CHG.$fileChanges))
                    {
                        $fileChanges = 'not found';
                    }
                    $aFiles[$version]['changeset'] = $fileChanges;
                    if (!file_exists(MAX_CHG.$fileMigrate))
                    {
                        $fileMigrate = 'not found';
                    }
                    $aFiles[$version]['migration'] = $fileMigrate;
                    $aFiles[$version]['schema'] = $fileSchema;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }
    */

}

?>